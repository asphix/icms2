<?php

class actionUsersMigrationsEdit extends cmsAction {

    public function run($rule_id){

        if (!$rule_id) { cmsCore::error404(); }

        $users_model = cmsCore::getModel('users');

        $form = $this->getForm('migration', array('edit'));

        $is_submitted = $this->request->has('submit');

        $rule = $users_model->getMigrationRule($rule_id);

        if ($is_submitted){

            $rule = $form->parse($this->request, $is_submitted);
            $errors = $form->validate($this,  $rule);

            if (!$errors){

                $users_model->updateMigrationRule($rule_id, $rule);

                $this->redirectToAction('migrations');

            }

            if ($errors){

                cmsUser::addSessionMessage(LANG_FORM_ERRORS, 'error');

            }

        }

        return cmsTemplate::getInstance()->render('backend/migration', array(
            'do' => 'edit',
            'rule' => $rule,
            'form' => $form,
            'errors' => isset($errors) ? $errors : false
        ));

    }

}

