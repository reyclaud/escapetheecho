<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.helper');

class EteViewBackend extends JViewLegacy {

    function display($tpl = null) {
        $document = JFactory::getDocument();
        
        $this->model = $this->getModel('Backend');

        $document->addStyleSheet(JURI::base() . 'components/com_ete/assets/backend/css/styles.css');
        $document->addScript(JURI::base() . 'components/com_ete/assets/backend/js/backend.js');
        $document->addScript(JURI::base() . 'components/com_ete/assets/backend/js/menu.js');

        $layoutName = $this->getLayout();                

        $quizId = JRequest::getVar('quizId', null);

        if (!is_null($quizId) && $this->get('Form')) {
            $this->formTitle = $this->get('Form')->FormTitle;
            $this->submissions = $this->get('Submissions');
            $this->properties = $this->get('FormProperties');
            $this->answers = $this->get('SubmissionAnswers');
        }
        
        $this->totalRegisteredUser = $this->get('TotalRegisteredUsers');

        if (!is_null($quizId)) {
            $model = $this->getModel('Backend');
            $this->form = $model->getForm();
        }                

        if (method_exists($this, $layoutName)) {
            $this->$layoutName();
        }

        // Display the view
        parent::display($tpl);
    }
    
    function briefingbuilderedit(){
        $model = $this->getModel('Backend');
        $this->LinkReview = $model->getLinkReview();
    }
    
    function briefingbuildereditor(){
        $model = $this->getModel('Backend');
        $this->LinkReviews = $model->getLinkReviews();        
        $this->briefingForms = $model->getBriefingForms();        
    }
    function emailbuilder_email_review(){
        $model = $this->getModel('Backend');        
        $this->briefingForms = $model->getBriefingForms();        
    }
    function emailbuilder(){
        $model = $this->getModel('Backend');
        $this->LinkReviews = $model->getLinkReviews();        
        $this->briefingForms = $model->getBriefingForms();        
    }

    function briefingbuilder_answers() {
        $model = $this->getModel('Backend');
        $this->questionName = $model->_getQuestionName();
        $this->answers = $model->getQuestionAnswers();
    }
    
    function briefing_edit() {
        $model = $this->getModel('Backend');
        $this->briefing = $model->_getBriefing();        
    }

    function briefingbuilder_qna() {
        $model = $this->getModel('Backend');
        $this->formTitle = $model->getForm()->FormTitle;

        $this->submissions = $model->getSubmissions();
        $this->questionName = $model->_getQuestionName();
        $this->answers = $model->getQuestionAnswers();
        $this->properties = $model->getFormProperties();
    }

    function briefingbuilder_qna_ajax() {
        $model = $this->getModel('Backend');
        $this->form = $model->getForm();
        $this->formTitle = $model->getForm()->FormTitle;

        $this->submissions = $model->getSubmissions();
        $this->questionName = $model->_getQuestionName();
        $this->answers = $model->getQuestionAnswers();
        $this->properties = $model->getFormProperties();
    }

    function briefingbuilder_questions() {
        $model = $this->getModel('Backend');
        $this->submissions = $model->getSubmissions();
        $this->properties = $model->getFormProperties();
    }

    function quizzes_respondents() {

        $model = $this->getModel('Backend');
        $this->respondents = $model->getRespondents();
    }

    function quizzes_bank() {

        $model = $this->getModel('Backend');
        $this->respondents = $model->getRespondents();
    }

    function quizzes_briefing_sheets() {

        $model = $this->getModel('Backend');
        $this->respondents = $model->getRespondents();
    }

}
