<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<li class="company-list__item">
    <div class="company-list__item-title"><?= $UF_NAME ?></div>
    <button data-doc-id="<?= $ID ?>" class="company-list__item-btn doc-action-update">
        <? if($UF_ACTIVE): ?>
            <svg width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 16H13V4.75L10.0968 1H1V16Z" stroke="#343434"/>
                <path d="M4 8.16667L6 10.5L10 7" stroke="#343434"/>
            </svg>
            <?=Loc::getMessage('ACTIVE_DOC')?>
        <? else: ?>
            <svg width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.09677 6H9.90323M4.09677 8.69231H9.90323M4.09677 11.3846H9.90323M13 16H1V1H10.0968L13 4.75V16Z" stroke="#343434"/>
            </svg>
            <?=Loc::getMessage('NO_ACTIVE_DOC')?>
        <? endif; ?>
    </button>
</li>