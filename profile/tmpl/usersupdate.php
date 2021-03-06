<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<li class="company-list__item">
    <div class="company-list__item-title"><?= $LAST_NAME . ' ' . $NAME . ' ' . $SECOND_NAME?></div>
    <? if(in_array(UserRole::$admin, $GROUPS)): ?>
        <button data-id="<?= $ID ?>" data-action="delAdmin" class="user_action company-list__item-btn company-list__item-btn--delete-admin">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.91724 1.18757C5.44633 2.41258 4.0451 2.99298 2.84591 2.45975C2.73676 2.41122 2.62654 2.43405 2.54755 2.49596L1.83924 1.78765C2.1913 1.45423 2.72458 1.3114 3.25221 1.54601C3.92831 1.84665 4.71833 1.51942 4.98383 0.828754C5.4086 -0.276251 6.97197 -0.276251 7.39675 0.828754C7.66225 1.51942 8.45226 1.84665 9.12837 1.54601C10.2101 1.06502 11.3156 2.17049 10.8346 3.25221C10.5339 3.92831 10.8612 4.71833 11.5518 4.98383C12.6568 5.4086 12.6568 6.97197 11.5518 7.39675C10.8612 7.66225 10.5339 8.45226 10.8346 9.12837C11.0692 9.65599 10.9263 10.1893 10.5929 10.5413L9.88461 9.83302C9.94652 9.75403 9.96935 9.64382 9.92082 9.53467C9.38759 8.33547 9.968 6.93425 11.193 6.46334C11.4431 6.3672 11.4431 6.01337 11.193 5.91724C9.968 5.44633 9.38759 4.0451 9.92082 2.84591C10.0297 2.60109 9.77949 2.35089 9.53467 2.45975C8.33547 2.99298 6.93425 2.41258 6.46334 1.18757C6.3672 0.937478 6.01337 0.937478 5.91724 1.18757ZM1.63622 5.68585C1.49852 5.77734 1.34861 5.85533 1.18757 5.91724C0.937478 6.01337 0.937478 6.3672 1.18757 6.46334C2.41258 6.93425 2.99298 8.33547 2.45975 9.53467C2.35089 9.77949 2.60109 10.0297 2.84591 9.92082C4.0451 9.38759 5.44633 9.968 5.91724 11.193C6.01337 11.4431 6.3672 11.4431 6.46334 11.193C6.52525 11.032 6.60323 10.8821 6.69473 10.7444L7.42793 11.4776C7.41686 11.5018 7.40645 11.5266 7.39675 11.5518C6.97197 12.6568 5.4086 12.6568 4.98383 11.5518C4.71833 10.8612 3.92831 10.5339 3.25221 10.8346C2.17049 11.3156 1.06502 10.2101 1.54601 9.12837C1.84665 8.45226 1.51942 7.66225 0.828754 7.39675C-0.276251 6.97197 -0.276251 5.4086 0.828754 4.98383C0.853997 4.97412 0.878754 4.96372 0.903013 4.95264L1.63622 5.68585ZM7.98332 7.93173C8.42095 7.48148 8.69043 6.86694 8.69043 6.18945C8.69043 4.80874 7.57114 3.68945 6.19043 3.68945C5.51295 3.68945 4.8984 3.95894 4.44815 4.39656L5.15537 5.10379C5.42456 4.84707 5.78909 4.68945 6.19043 4.68945C7.01886 4.68945 7.69043 5.36103 7.69043 6.18945C7.69043 6.59079 7.53281 6.95532 7.27609 7.22451L7.98332 7.93173Z" fill="#343434"/>
                <line x1="1.04398" y1="1.3359" x2="11.044" y2="11.3359" stroke="#343434"/>
            </svg>
            <?=Loc::getMessage('DEL_ADMIN')?>
        </button>
    <? elseif(in_array(UserRole::$oldUser, $GROUPS)): ?>
        <button data-id="<?= $ID ?>" data-action="addAdmin" class="user_action company-list__item-btn company-list__item-btn--appoint-admin">
            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.76024 3.31787C8.0207 2.64033 8.9793 2.64033 9.23976 3.31787C9.60796 4.27571 10.7036 4.72953 11.6412 4.3126C12.3045 4.01767 12.9823 4.6955 12.6874 5.35877C12.2705 6.29642 12.7243 7.39204 13.6821 7.76024C14.3597 8.0207 14.3597 8.9793 13.6821 9.23976C12.7243 9.60796 12.2705 10.7036 12.6874 11.6412C12.9823 12.3045 12.3045 12.9823 11.6412 12.6874C10.7036 12.2705 9.60796 12.7243 9.23976 13.6821C8.9793 14.3597 8.0207 14.3597 7.76024 13.6821C7.39204 12.7243 6.29642 12.2705 5.35877 12.6874C4.6955 12.9823 4.01767 12.3045 4.3126 11.6412C4.72953 10.7036 4.27571 9.60796 3.31787 9.23976C2.64033 8.9793 2.64033 8.0207 3.31787 7.76024C4.27571 7.39204 4.72953 6.29642 4.3126 5.35877C4.01767 4.6955 4.6955 4.01767 5.35877 4.3126C6.29642 4.72953 7.39204 4.27571 7.76024 3.31787Z" stroke="#343434"/>
                <circle cx="8.5" cy="8.5" r="2" stroke="#343434"/>
            </svg>
            <?=Loc::getMessage('ADD_ADMIN')?>
        </button>
    <? else: ?>
        <button data-id="<?= $ID ?>" data-action="confirm" class="user_action company-list__item-btn company-list__item-btn--confirm-account">
            <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.04785 5.5L4.54785 9L11.0479 1" stroke="#343434" stroke-width="2"/>
            </svg>
            <?=Loc::getMessage('CONFIRM_USER')?>
        </button>
    <? endif; ?>

    <? if($ACTIVE == 'Y'): ?>
        <button data-id="<?= $ID ?>" data-action="lock" class="user_action company-list__item-btn company-list__item-btn--lock">
            <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" y="7.24609" width="9.15305" height="5.25466" stroke="#343434"/>
                <path d="M1.8457 7L1.8457 2.99991C1.8457 1.89534 2.74113 0.999904 3.8457 0.999904L6.30674 0.999903C7.4113 0.999903 8.30674 1.89533 8.30674 2.9999L8.30674 7.46094" stroke="#343434"/>
            </svg>
            <?=Loc::getMessage('LOCK_USER')?>
        </button>
    <? else: ?>
        <button data-id="<?= $ID ?>" data-action="unlock" class="user_action company-list__item-btn company-list__item-btn--unlock">
            <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" y="7.24609" width="9.15305" height="5.25466" stroke="#343434"/>
                <path d="M1.8457 3V3C1.8457 1.89543 2.74113 0.999904 3.8457 0.999904L6.30674 0.999903C7.4113 0.999903 8.30674 1.89533 8.30674 2.9999L8.30674 7.46094" stroke="#343434"/>
            </svg>
            <?=Loc::getMessage('UNLOCK_USER')?>
        </button>
    <? endif; ?>
</li>
