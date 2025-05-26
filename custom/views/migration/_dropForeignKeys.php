<?php declare(strict_types=1);
foreach ($foreignKeys as $column => $fkData) { ?>
        // drops foreign key for table `<?php echo $fkData['relatedTable']; ?>`
        $this->dropForeignKey(
            '<?php echo $fkData['fk']; ?>',
            '<?php echo $table; ?>'
        );

        // drops index for column `<?php echo $column; ?>`
        $this->dropIndex(
            '<?php echo $fkData['idx']; ?>',
            '<?php echo $table; ?>'
        );

<?php }
