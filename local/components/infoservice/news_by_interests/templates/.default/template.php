<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<?

global $USER;
if ($USER->IsAuthorized()): ?>

    <p><b><?= GetMessage("INFOSERVICE_NEWS_BY_INTERESTS_AUTHORS_AND_NEWS") ?></b></p>

    <ul>
        <? foreach ($arResult['AUTHORS'] as $iID => $arAuthor): ?>
            <li>
                [<?= $iID ?>] - <?= $arAuthor['LOGIN'] ?>
                <ul>
                    <? foreach ($arAuthor['NEWS'] as $arNews): ?>
                        <li>
                            - <?= $arNews['NAME'] ?>
                        </li>
                    <? endforeach; ?>
                </ul>
            </li>
        <? endforeach; ?>
    </ul>

<? endif; ?>