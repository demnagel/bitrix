<?php
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true) die() ;

use Bitrix\Main\Localization\Loc;

$user_role = UserRole::getRoleForGroups($arResult['CURRENT_USER']['GROUPS']);

if($arParams['TITLE']){
    $APPLICATION->SetTitle($arParams['TITLE']);
}

if($arResult['COMPANY']): ?>
<main class="main-company-profile">
    <section class="company-profile">

        <? $APPLICATION->IncludeFile('/include/lk/aside_menu.php'); /* Блок с левым меню */?>

        <div class="company-profile__container">
            <form action="" class="company-profile__form" method="post">
                <?= bitrix_sessid_post() ?>
                <div class="company-profile__top">
                    <h3 class="profile-title"><?= Loc::getMessage('PERSONAL_INFO_CAPTION') ?></h3>
                    <label class="profile-label" for="full-name"><?= Loc::getMessage('COMPANY_FULL_NAME') ?></label>
                    <input class="profile-input" type="text" name="COMPANY[UF_FULL_NAME]" id="full-name" value="<?= $arResult['COMPANY']['UF_FULL_NAME'] ?>">
                    <label class="profile-label" for="short-name"><?= Loc::getMessage('COMPANY_NAME') ?></label>
                    <input class="profile-input" type="text" name="COMPANY[UF_NAME]" id="short-name" value="<?= $arResult['COMPANY']['UF_NAME'] ?>">
                </div>

                <div class="company-profile__bottom">
                    <div class="company-profile__bottom-col">
                        <h3 class="profile-title"><?= Loc::getMessage('CONTACTS_INFO_CAPTION') ?></h3>
                        <label class="profile-label" for="email"><?= Loc::getMessage('COMPANY_EMAIL') ?></label>
                        <input class="profile-input" type="email" id="email" name="COMPANY[UF_EMAIL]" value="<?= $arResult['COMPANY']['UF_EMAIL'] ?>">
                        <label class="profile-label" for="phone"><?= Loc::getMessage('COMPANY_PHONE') ?></label>
                        <input class="profile-input" type="tel" id="phone" name="COMPANY[UF_PHONE]" value="<?= $arResult['COMPANY']['UF_PHONE'] ?>">
                        <label class="profile-label" for="fax"><?= Loc::getMessage('COMPANY_FAX') ?></label>
                        <input class="profile-input" type="tel" id="fax" name="COMPANY[UF_FAX]" value="<?= $arResult['COMPANY']['UF_FAX'] ?>">
                        <label class="profile-label" for="index"><?= Loc::getMessage('COMPANY_POST') ?></label>
                        <input class="profile-input" type="text" id="index" name="COMPANY[UF_POST_ADDRESS]" value="<?= $arResult['COMPANY']['UF_POST_ADDRESS'] ?>">
                        <label class="profile-label" for="address"><?= Loc::getMessage('COMPANY_JUR_ADDRESS') ?></label>
                        <input class="profile-input" type="text" id="address" name="COMPANY[UF_JUR_ADDRESS]" value="<?= $arResult['COMPANY']['UF_JUR_ADDRESS'] ?>">
                    </div>
                    <div class="company-profile__bottom-col">
                        <h3 class="profile-title"><?= Loc::getMessage('COMPANY_REQUISITE') ?></h3>
                        <label class="profile-label" for="TIN"><?= Loc::getMessage('COMPANY_INN') ?></label>
                        <input class="profile-input" type="text" id="TIN" name="COMPANY[UF_INN]" value="<?= $arResult['COMPANY']['UF_INN'] ?>">
                        <label class="profile-label" for="OGRN"><?= Loc::getMessage('COMPANY_OGRN') ?></label>
                        <input class="profile-input" type="text" id="OGRN" name="COMPANY[UF_OGRN]" value="<?= $arResult['COMPANY']['UF_OGRN'] ?>">
                        <label class="profile-label" for="CAT"><?= Loc::getMessage('COMPANY_KPP') ?></label>
                        <input class="profile-input" type="text" id="CAT" name="COMPANY[UF_KPP]" value="<?= $arResult['COMPANY']['UF_KPP'] ?>">
                        <label class="profile-label" for="OKPO"><?= Loc::getMessage('COMPANY_OKPO') ?></label>
                        <input class="profile-input" type="text" id="OKPO" name="COMPANY[UF_OKPO]" value="<?= $arResult['COMPANY']['UF_OKPO'] ?>">
                        <label class="profile-label" for="current-account"><?= Loc::getMessage('COMPANY_PAYMENT_ACCOUNT') ?></label>
                        <input class="profile-input" type="text" id="current-account" name="COMPANY[UF_PAYMENT_ACCOUNT]" value="<?= $arResult['COMPANY']['UF_PAYMENT_ACCOUNT'] ?>">
                        <label class="profile-label" for="correspondent-account"><?= Loc::getMessage('COMPANY_CORRESPONDENT_ACCOUNT') ?></label>
                        <input class="profile-input" type="text" id="correspondent-account" name="COMPANY[UF_CORRESPONDENT_ACCOUNT]" value="<?= $arResult['COMPANY']['UF_CORRESPONDENT_ACCOUNT'] ?>">
                        <label class="profile-label" for="bank-name"><?= Loc::getMessage('COMPANY_BANK_NAME') ?></label>
                        <input class="profile-input" type="text" id="bank-name" name="COMPANY[UF_BANK_NAME]" value="<?= $arResult['COMPANY']['UF_BANK_NAME'] ?>">
                        <label class="profile-label" for="BIC"><?= Loc::getMessage('COMPANY_BANK_BIK') ?></label>
                        <input class="profile-input" type="text" id="BIC" name="COMPANY[UF_BIK]" value="<?= $arResult['COMPANY']['UF_BIK'] ?>">
                    </div>
                </div>
                <input class="client-profile__form-btn" type="submit" name="EDIT_COMPANY" value="<?= Loc::getMessage('SAVE_BTN_CAPTION') ?>"/>
            </form>

            <form class="company-profile__dropzone">
                <?= bitrix_sessid_post() ?>
                <input type="hidden" name="ACTION" value="uploadFile">
                <input type="hidden" name="IS_AJAX" value="Y">
                <div class="dropzone">
                    <h3 class="company-profile__dropzone-title"><?= Loc::getMessage('DROP_CAPTION') ?></h3>
                    <input id="file-input" type="file" name="file" multiple>
                    <label class="company-profile__dropzone-btn" for="file-input"><?= Loc::getMessage('DROP_LOAD') ?></label>
                    <span><?= Loc::getMessage('DROP_TEXT') ?></span>
                </div>
                <div class="company-profile__dropzone-unavailable <?= $arResult['COMPANY']['FILE_DATA']? '' : 'hidden'?>">
                    <h3 class="company-profile__dropzone-title"><?= Loc::getMessage('DROP_CAPTION') ?></h3>
                    <ul class="company-profile__dropzone-list">
                        <li id="file-name"><?= $arResult['COMPANY']['FILE_DATA']['name'] ?></li>
                        <li>
                            <span id="file-type"><?= $arResult['COMPANY']['FILE_DATA']['type'] ?></span>,
                            <span id="file-size"><?= ceil($arResult['COMPANY']['FILE_DATA']['size'] / 1024) ?> Kb</span>
                        </li>
                        <li class="company-profile__btn-item btn_parent">
                            <? if($arResult['COMPANY']['UF_FILE']) $data = "id='file_delete' data-file-id='{$arResult['COMPANY']['UF_FILE']}'"; ?>
                            <button <?= $data ?? ''?> class="company-profile__btn company-profile__btn-delete" ><?= Loc::getMessage('DEL_BTN_CAPTION') ?></button>
                            <button class="company-profile__btn company-profile__btn-save <?= $arResult['COMPANY']['FILE_DATA']? 'hidden' : ''?>" type="submit" href=""><?= Loc::getMessage('SAVE_BTN_CAPTION') ?></button>
                        </li>
                    </ul>
                </div>
            </form>

        </div>
    </section>

    <? if($arResult['COMPANY']['UF_COMPANY_AGREEMENT']): ?>
    <section class="company-contracts">
        <div class="company-contracts__container">
            <div class="company-list__bg">
                <h2 class="company-list__title"><?= Loc::getMessage('DOCS_COMPANY') ?></h2>
                <ul class="company-list docs_parent">

                    <?= $component->collectTmpl($arResult['COMPANY']['UF_COMPANY_AGREEMENT'], $component->getTmplPath('docupdate')); ?>

                </ul>
            </div>
        </div>
    </section>
    <? endif; ?>

    <? if($arResult['USERS'] && ($user_role == UserRole::ADMIN || $user_role == UserRole::MANAGER)): ?>
    <section class="company-employees">
        <div class="company-employees__container">
            <div class="company-list__bg">
                <h2 class="company-list__title"><?= Loc::getMessage('USERS_COMPANY') ?></h2>
                <ul class="company-list users_parent">

                    <?= $component->collectTmpl($arResult['USERS'], $component->getTmplPath('usersupdate')); ?>

                </ul>
            </div>
        </div>
    </section>
    <? endif; ?>

    <?
    if($user_role != UserRole::MANAGER){
        if($arResult['COMPANY']['UF_PERSONAL_MANAGER']) {
            $manager = &$arResult['COMPANY']['UF_PERSONAL_MANAGER'];

            $params = [
                'title' => Loc::getMessage('PERSONAL_MANAGER_CAPTION'),
                'name' => $manager['LAST_NAME'] . ' ' . $manager['NAME'] . ' ' . $manager['SECOND_NAME'],
                'company' => $arResult['COMPANY']['UF_NAME'],
                'phone' => $manager['PERSONAL_PHONE'],
                'email' => $manager['EMAIL'],
                'btn_caption' => Loc::getMessage('PERSONAL_MANAGER_SEND_BTN'),
            ];

            unset($manager);

            echo Helpers::renderTmpl(PERS_MANAGER_TMPL, $params);

        }
    }
    ?>
</main>
<? endif; ?>