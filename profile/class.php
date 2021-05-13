<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\UserTable;

class ProfilesForUserAndOrganisation extends CBitrixComponent
{

    private $tmpl_path = '/tmpl';

    private function _checkLibs()
    {
        if (!class_exists('HlWorker')) {
            throw new \Exception('Не найден класс HlWorker - необходимый для работы компонента');
        }
        if (!class_exists('UserRole')) {
            throw new \Exception('Не найден класс UserRole - необходимый для работы компонента');
        }
        return true;
    }

    public function onPrepareComponentParams($arParams)
    {
        if((int)$_GET['user_id'] && $arParams['MAIN'] == 'user'){
            $arParams['USER_ID'] = (int)$_GET['user_id'];
        }
        else{
            global $USER;
            $arParams['USER_ID'] = $USER->GetID();
        }

        if((int)$_GET['company_id'] && $arParams['MAIN'] == 'company'){
            $arParams['UF_COMPANY'] = $_GET['company_id'];
        }
        else{
            $rsUsers = CUser::GetByID($arParams['USER_ID']);
            $arUser = $rsUsers->Fetch();
            $arParams['UF_COMPANY'] = $arUser['UF_COMPANY'];
        }

        return $arParams;
    }

    public function executeComponent()
    {

        $this->_checkLibs();

        Bitrix\Main\Page\Asset::getInstance()->addJs($this->getPath() . '/script.js');

        // Ответ для ajax
        if ($_POST['IS_AJAX'] == 'Y' && $_POST['ACTION']) {
            if (bitrix_sessid()) {
                $this->answerAjax();
            }
        }

        // Редактирование компании
        if ($_POST['EDIT_COMPANY']) {
            if (bitrix_sessid()) {
                $this->updateFieldsCompany($_POST['COMPANY']);
            }
        }

        // Редактирование пользователя
        if ($_POST['EDIT_USER']) {
            if (bitrix_sessid()) {
                $this->updateFieldsUser($_POST['USER']);
            }
        }


        if ($this->StartResultCache()) {

            $this->arResult['COMPANY'] = $this->getCompanyData($this->arParams['UF_COMPANY']);

            $rsUsers = CUser::GetByID($this->arParams['USER_ID']);
            $this->arResult['CURRENT_USER'] = $rsUsers->Fetch();
            $this->arResult['CURRENT_USER']['GROUPS'] = \CUser::GetUserGroup($this->arResult['CURRENT_USER']['ID']);

            if ($this->arResult['COMPANY']['UF_COMPANY_AGREEMENT']) {
                $this->arResult['COMPANY']['UF_COMPANY_AGREEMENT'] = $this->getDocsCompany($this->arResult['COMPANY']['UF_COMPANY_AGREEMENT']);
            }

            $this->arResult['USERS'] = $this->getUsersCompany();

            $this->includeComponentTemplate();
        }
    }


    // Роутер для ajax запросов
    private function answerAjax()
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        $method = $_POST['ACTION'];

        if (method_exists(__CLASS__, $method)) {
            $this->$method();
        }

        die();
    }


    // Данные компании
    private function getCompanyData($id)
    {
        $params = [
            'select' => ['*'],
            'filter' => [
                'ID' => $id
            ]
        ];

        $company = new HlWorker(['TABLE' => $this->arParams['COMPANIES_TABLE_NAME']]);
        $result = $company->getList($params)[$id];

        if ($result['UF_PERSONAL_MANAGER']) {
            $rsUser = CUser::GetByID($result['UF_PERSONAL_MANAGER']);
            $result['UF_PERSONAL_MANAGER'] = $rsUser->Fetch();
        }

        if ($result['UF_FILE']) {
            $result['FILE_DATA'] = CFile::MakeFileArray($result['UF_FILE']);
        }

        return $result;
    }


    // Документы пренадлежащие компании
    private function getDocsCompany($id)
    {
        $params = [
            'select' => ['*'],
            'filter' => [
                'ID' => $id
            ]
        ];

        $docs = new HlWorker(['TABLE' => $this->arParams['DOCS_TABLE_NAME']]);
        return $docs->getList($params);
    }


    // Путь к шаблону метода
    public function getTmplPath($method)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . $this->getPath() . $this->tmpl_path . '/' . mb_strtolower($method) . '.php';

        if (!file_exists($path)) {
            return false;
        }

        return $path;
    }

    // Ответ для ajax на переназначение договора компании
    private function docUpdate()
    {
        if ($_POST['DOC_ON'] && $_POST['DOCS_ALL']) {

            $docs = new HlWorker(['TABLE' => $this->arParams['DOCS_TABLE_NAME']]);
            $docs->updateItem($_POST['DOC_ON'], ['UF_ACTIVE' => 1]);

            foreach ($_POST['DOCS_ALL'] as $id) {
                if ($id == $_POST['DOC_ON']) continue;
                $docs->updateItem($id, ['UF_ACTIVE' => 0]);
            }

            $companies = $this->getDocsCompany($_POST['DOCS_ALL']);
            $tmpl = $this->getTmplPath($_POST['ACTION']);

            if ($companies && $tmpl) {
                echo $this->collectTmpl($companies, $tmpl);
            }
        }
    }


    // Редактирование компании ajax
    private function updateCompany()
    {
        echo json_encode(['result' => $this->updateFieldsCompany($_POST['COMPANY'])]);
    }


    // Загрузка карточки организации
    private function uploadFile()
    {

        $arFile = $_FILES['file'];
        $fid = CFile::SaveFile($arFile, "companies_doc");

        if(!$fid) {
            echo json_encode(['result' => false, 'error' => 'Не удалось загрузить файл']);;
            return false;
        }

        $fields = [
            'UF_FILE' => CFile::MakeFileArray($fid)
        ];

        $company = new HlWorker(['TABLE' => $this->arParams['COMPANIES_TABLE_NAME']]);
        $res = $company->updateItem($this->arParams['UF_COMPANY'], $fields);

        echo json_encode(['result' => $res, 'id' => $fid]);

    }

    // Удаление карточки компании
    private function fileDelete()
    {

        if (CFile::GetPath($_POST['FILE_ID'])) {

            $fields = [
                'UF_FILE' => ['del' => 'Y']
            ];

            $company = new HlWorker(['TABLE' => $this->arParams['COMPANIES_TABLE_NAME']]);
            $res = $company->updateItem($this->arParams['UF_COMPANY'], $fields);

            CFile::Delete($_POST['FILE_ID']);

            echo json_encode(['result' => $res]);
        }
        else{
            echo json_encode(['result' => false, 'error' => 'Файл с таким id отсутствует']);
        }

    }


    // Сборка контента из доп шаблонов
    public function collectTmpl(array $items, $tmpl, $one_element = false)
    {
        ob_start();

        if ($one_element) {
            extract($items);
            require $tmpl;
        } else {
            foreach ($items as $item) {
                extract($item);
                require $tmpl;
            }
        }

        return ob_get_clean();
    }


    // Обновление полей компании
    private function updateFieldsCompany(array $fields)
    {
        $company = new HlWorker(['TABLE' => $this->arParams['COMPANIES_TABLE_NAME']]);
        return $company->updateItem($this->arParams['UF_COMPANY'], $this->safe($fields));
    }

    // Обновление полей пользователя
    private function updateFieldsUser(array $fields)
    {
        $user = new CUser;

        if ($fields['NEW_PASSWORD'] && $fields['NEW_PASSWORD_CONFIRM']) {
            if ($fields['NEW_PASSWORD'] === $fields['NEW_PASSWORD_CONFIRM']) {

                $fields['PASSWORD'] = $fields['NEW_PASSWORD'];
                $fields['CONFIRM_PASSWORD'] = $fields['NEW_PASSWORD_CONFIRM'];

            }
        }

        unset($fields['NEW_PASSWORD']);
        unset($fields['NEW_PASSWORD_CONFIRM']);

        if ($user->Update($this->arParams['USER_ID'], $this->safe($fields))) {
            return true;
        } else {
            return $user->LAST_ERROR;
        }

    }


    // Сотрудники компании
    private function getUsersCompany()
    {
        $result = [];
        $params = [
            'select' => ['ID', 'NAME', 'LAST_NAME', 'SECOND_NAME', 'ACTIVE'],
            'filter' => [
                'UF_COMPANY' => $this->arParams['UF_COMPANY'],
                '!ID' => $this->arParams['USER_ID']
            ],
        ];

        $users = UserTable::getList($params);
        while ($arUser = $users->Fetch()) {
            $arUser['GROUPS'] = \CUser::GetUserGroup($arUser['ID']);
            $result[] = $arUser;
        }
        return $result;
    }


    // Очистка полей
    private function safe(array $arr)
    {
        $callback = function ($field) {
            return trim(strip_tags($field));
        };

        return array_map($callback, $arr);
    }


    // Редактирование пользователей (группы, активность), ответ для ajax
    private function usersUpdate()
    {
        $user = new CUser;
        $arGroups = $user->GetUserGroup($_POST['USER_ID']);
        $fields = [];

        switch ($_POST['METHOD']) {
            case 'unlock':
                $fields = ['ACTIVE' => 'Y'];
                break;

            case 'lock':
                $fields = ['ACTIVE' => 'N'];
                break;

            case 'confirm':
                $fields = [
                    'GROUP_ID' => UserRole::setRole($arGroups, UserRole::$oldUser),
                    'UF_DATE_CONFIRM' => date('d.m.Y')
                ];
                break;

            case 'delAdmin':
                $key = array_search(UserRole::$admin, $arGroups);
                if ($key !== false) {
                    $fields = ['GROUP_ID' => UserRole::setRole($arGroups, UserRole::$oldUser)];
                }
                break;

            case 'addAdmin':
                $fields = ['GROUP_ID' => UserRole::setRole($arGroups, UserRole::$admin)];
                break;
        }

        if ($fields) {
            if ($user->Update($_POST['USER_ID'], $fields)) {

                $users = $this->getUsersCompany();
                $tmpl = $this->getTmplPath($_POST['ACTION']);

                if ($users && $tmpl) {
                    echo $this->collectTmpl($users, $tmpl);
                }

            }
        }
    }

}