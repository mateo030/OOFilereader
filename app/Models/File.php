<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use PDO;

class File extends Model
{
    public function create(string $date, string $checkNumber, string $description, float $amount): int
    {
        $stmt = $this->db->prepare('INSERT INTO transaction_table (date, checkNumber, description, amount) VALUES (:date, :checkNumber, :description, :amount)');
        $stmt->execute([$date, $checkNumber, $description, $amount]);

        return (int) $this->db->lastInsertId();
    }

    public function find(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM transaction_table;');
        $stmt->execute();
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $transactions;
    }

    public function calculate(array $transactions): array
    {
        $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

        foreach ($transactions as $transaction) {
            $totals['netTotal'] += $transaction['amount'];

            if($transaction['amount'] >= 0) {
                $totals['totalIncome'] += $transaction['amount'];
            } else {
                $totals['totalExpense'] += $transaction['amount'];
            }
        }

        return $totals;
    }
}