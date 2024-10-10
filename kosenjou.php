<?php

function calculateHellEfficiency($timeFor95Hell) {
    // 各hellの貢献度を定義
    $contribution = [
        '95hell' => 910385,
        '100hell' => 2662745,
        '150hell' => 4121026,
        '200hell' => 13354849,
    ];

    // 95hell の貢献度あたりの秒数を計算
    $contributionPerSecond95Hell = $contribution['95hell'] / $timeFor95Hell;

    // 各hellにおける95hell以上の貢献度を得るのにかかる秒数を計算
    $result = [];
    foreach ($contribution as $hell => $contributionValue) {
        if ($hell !== '95hell') {
            $requiredTime = round($contributionValue / $contributionPerSecond95Hell, 2); // 秒数を計算し小数点第2位で丸める
            $result[$hell] = $requiredTime;
        }
    }

    return $result;
}

function formatTime($seconds) {
    // 浮動小数点を整数に変換してから分と秒に分ける
    $seconds = (int)round($seconds);
    $minutes = floor($seconds / 60);
    $remainingSeconds = $seconds % 60;
    return "{$minutes}分{$remainingSeconds}秒";
}

function validateInput($input) {
    // 入力が数値であるかチェック
    if (!is_numeric($input)) {
        echo "秒単位の数値で入力してください。\n";
        return false;
    }
    return true;
}

// ユーザーの入力
echo "95hellの討伐にかかる秒数を入力してください: ";
$handle = fopen("php://stdin", "r");
$timeFor95Hell = trim(fgets($handle));

// バリデーション
if (validateInput($timeFor95Hell)) {
    $timeFor95Hell = (float)$timeFor95Hell;  // 数値に変換
    $efficiencyResults = calculateHellEfficiency($timeFor95Hell);

    echo "95hellを{$timeFor95Hell}秒で討伐できたとすると…\n";
    foreach ($efficiencyResults as $hell => $time) {
        $formattedTime = formatTime($time); // 分と秒に変換
        echo "- {$hell}: {$time}秒以内 ({$formattedTime}以内)\n";
    }
    echo "これ以上かかる秒数で討伐すると、95hellを周回した方がより貢献度を稼ぐことができます。\n";
}
