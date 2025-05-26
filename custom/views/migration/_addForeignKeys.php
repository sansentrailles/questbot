<?php declare(strict_types=1);
foreach ($foreignKeys as $column => $fkData) { ?>

        // creates index for column `<?php echo $column; ?>`
        $this->createIndex(
            '<?php echo $fkData['idx']; ?>',
            '<?php echo $table; ?>',
            '<?php echo $column; ?>'
        );

        // add foreign key for table `<?php echo $fkData['relatedTable']; ?>`
        $this->addForeignKey(
            '<?php echo $fkData['fk']; ?>',
            '<?php echo $table; ?>',
            '<?php echo $column; ?>',
            '<?php echo $fkData['relatedTable']; ?>',
            '<?php echo $fkData['relatedColumn']; ?>',
            'CASCADE'
        );
<?php }
