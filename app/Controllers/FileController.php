<?php

declare(strict_types=1);

namespace App\Controllers;

use DateTime;
use App\View;
use App\Models\File;

class FileController 
{
    private $transactionsData = [];

    public function transactions(): View
    {

        $fileModel = new File();

        foreach ($this->transactionsData as $transaction) {
            $fileModel->create($transaction['date'], $transaction['checkNumber'], $transaction['description'], $transaction['amount']);
        }
        return View::make('transactions', ['transaction' => $fileModel->find(), 'totals' => $fileModel->calculate($this->transactionsData)]);
    }

    public function upload()
    {
        $filePath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];

        move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath);

        $files = $this->getTransactionFiles(STORAGE_PATH);

        $transactions = [];

        foreach ($files as $file) {
            $this->transactionsData = array_merge($transactions, $this->getTransactions($file));
        }

        return $this->transactions();
    }

    public function getTransactionFiles(string $path): array
    {
        $files = [];

        foreach (scandir($path) as $file) {
            if(is_dir($file)) {
                continue;
            }

            $files[] = $path . $file;
        }

        return $files;
    }

    public function getTransactions(string $fileName): array
    {
        if (!file_exists($fileName)) {
            echo 'file does not exist';
            die();
        }

        $file = fopen($fileName, 'r');

        fgetcsv($file);

        $transactions = [];

        // Reads file line by line
        while (($transaction = fgetcsv($file)) !== false) {
            $transactions[] = $this->extractTransaction($transaction);
        }

        return $transactions;
    }

    function extractTransaction(array $transactionRow): array
    {
        [$date, $checkNumber, $description, $amount] = $transactionRow;
        
        $formattedDate = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');

        $formattedAmount = (float) str_replace(['$', ','], '', $amount);

        return [
            'date' => $formattedDate,
            'checkNumber' => $checkNumber,
            'description' => $description,
            'amount' => $formattedAmount,
        ];
    }
}