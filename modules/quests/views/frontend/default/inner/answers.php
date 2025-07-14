<div class="space-y-2 mb-4">
    <p class="text-gray-400">Варианты ответов:</p>
    <ul class="list-disc list-inside text-gray-300 ml-4">
        <?php foreach ($answers as $answer) { ?>
            <li<?php if ($answer->is_right) { ?> class="text-green-400 font-medium"<?php } ?>><?= $answer->title ?><?php if ($answer->is_right) { ?> ✅ (правильный)<?php } ?></li>
        <?php } ?>
    </ul>
</div>