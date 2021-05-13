<?
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

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$user_role = UserRole::getRoleForGroups($arResult['CURRENT_USER']['GROUPS']);

if($arParams['TITLE']){
    $APPLICATION->SetTitle($arParams['TITLE']);
}
?>
<main>
    <section class="client-profile">

        <? $APPLICATION->IncludeFile('/include/lk/aside_menu.php'); /* Блок с левым меню */?>

        <div class="client-profile__container">
            <form class="client-profile__form" method="post" action="" >
                <?= bitrix_sessid_post() ?>
                <div class="client-profile__col-wrapper">
                    <div class="client-profile__form-col">
                        <h3 class="profile-title"><?= Loc::getMessage('PERSONAL_INFO_CAPTION') ?></h3>

                        <label class="profile-label" for="main-profile-name"><?=Loc::getMessage('NAME')?></label>
                        <input class="profile-input" type="text" name="USER[NAME]" maxlength="50" id="main-profile-name" value="<?=$arResult["CURRENT_USER"]["NAME"]?>" required/>

                        <label class="profile-label" for="main-profile-second-name"><?=Loc::getMessage('SECOND_NAME')?></label>
                        <input class="profile-input" type="text" name="USER[SECOND_NAME]" maxlength="50" id="main-profile-second-name" value="<?=$arResult["CURRENT_USER"]["SECOND_NAME"]?>" required/>

                        <label class="profile-label" for="main-profile-last-name"><?=Loc::getMessage('LAST_NAME')?></label>
                        <input class="profile-input" type="text" name="USER[LAST_NAME]" maxlength="50" id="main-profile-last-name" value="<?=$arResult["CURRENT_USER"]["LAST_NAME"]?>" required/>
                    </div>
                    <div class="client-profile__form-col">
                        <h3 class="profile-title"><?= Loc::getMessage('PERSONAL_INFO_CAPTION') ?></h3>

                        <label class="profile-label" for="main-profile-email"><?=Loc::getMessage('EMAIL')?></label>
                        <input class="profile-input" type="text" name="USER[EMAIL]" maxlength="50" id="main-profile-email" value="<?=$arResult["CURRENT_USER"]["EMAIL"]?>" required/>

                        <label class="profile-label" for="phone"><?=Loc::getMessage('PERSONAL_PHONE')?></label>
                        <input class="profile-input phone_mask" type="tel" name="USER[PERSONAL_PHONE]" maxlength="50" id="phone" placeholder="+7 (____) ___-__-__" value="<?=$arResult["CURRENT_USER"]["PERSONAL_PHONE"]?>" required/>

                        <label class="profile-label" for="phone2"><?=Loc::getMessage('PERSONAL_MOBILE')?></label>
                        <input class="profile-input phone_mask" type="tel" name="USER[PERSONAL_MOBILE]" maxlength="50" id="phone2" placeholder="+7 (____) ___-__-__" value="<?=$arResult["CURRENT_USER"]["PERSONAL_MOBILE"]?>" required/>

                    </div>
                    <div class="client-profile__form-col">
                        <h3 class="profile-title"><?= Loc::getMessage('PERSONAL_INFO_CAPTION') ?></h3>

                        <div class="password hide">
                            <label class="profile-label" for="main-profile-password"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
                            <input class="profile-input" type="password" name="USER[NEW_PASSWORD]" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
                        </div>

                        <div class="password hide">
                            <label class="profile-label" for="main-profile-password-confirm"><?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?></label>
                            <input class="profile-input" type="password" name="USER[NEW_PASSWORD_CONFIRM]" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off"/>
                        </div>
                    </div>
                </div>
                <p class="client-profile__form-warning"><sup>*</sup><?= Loc::getMessage('REQUIRED_FIELDS_CAPTION') ?></p>
                <input class="client-profile__form-btn" type="submit" name="EDIT_USER" value="<?= Loc::getMessage('SAVE_BTN_CAPTION') ?>"/>
            </form>
        </div>

    </section>

    <? if($arResult['COMPANY']): ?>
    <section class="company-info">
        <div class="company-info__container">
            <h2><?= Loc::getMessage('COMPANY_TITLE') ?></h2>
            <form action="" class="company-info__form" id="company_form">
                <?= bitrix_sessid_post() ?>
                <input type="hidden" name="ACTION" value="updatecompany">
                <input type="hidden" name="IS_AJAX" value="Y">
                <div class="company-info__item">
                    <label class="profile-label" for="title"><?= Loc::getMessage('COMPANY_NAME') ?></label>
                    <input class="profile-input" type="text" id="title" name="COMPANY[UF_NAME]" value="<?= $arResult['COMPANY']['UF_NAME'] ?>" required>
                </div>
                <div class="company-info__item">
                    <label class="profile-label" for="TIN"><?= Loc::getMessage('COMPANY_NAME') ?></label>
                    <input class="profile-input" type="text" id="TIN" name="COMPANY[UF_INN]" value="<?= $arResult['COMPANY']['UF_INN'] ?>" required>
                </div>
            </form>
            <p class="client-profile__form-warning"><sup>*</sup><?= Loc::getMessage('REQUIRED_FIELDS_CAPTION') ?></p>
            <input form="company_form" name="EDIT_COMPANY" class="company-info__form-btn" type="submit" value="<?= Loc::getMessage('EDIT_COMPANY_BTN_CAPTION') ?>"/>
        </div>
    </section>
    <? endif; ?>

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

    <? if($user_role != UserRole::MANAGER){
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
