<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaction as $row) : ?>
                    <tr>
                        <td><?= $row['date']?></td>
                        <td><?= $row['checkNumber']?></td>
                        <td><?= $row['description']?></td>
                        <td>
                            <?php if ($row['amount'] < 0) : ?>
                                <span style="color: red"><?= '$' . $row['amount']?></span>
                            <?php elseif ($row['amount'] > 0) : ?>
                                <span style="color: green"><?= '$' . $row['amount']?></span>
                            <?php else : ?>
                                <span><?= '$' . $row['amount']?></span>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= '$' . $totals['totalIncome'] ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= '$' . $totals['totalExpense'] ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= '$' . $totals['netTotal'] ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
