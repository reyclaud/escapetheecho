<?php

// No direct access to this file

defined('_JEXEC') or die('Restricted access');

class EteControllerBackend extends JControllerLegacy {

    public function showRespondents() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('quizzes_respondents');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function showLinkReview() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('link_review');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function getQuestions() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('briefingbuilder_questions');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function getAnswers() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('briefingbuilder_answers');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function showAnswers() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('briefingbuilder_answers');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function showQuestionAnswers() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('briefingbuilder_qna');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function showAjaxQuestionAnswers() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('briefingbuilder_qna_ajax');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function addToBank() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('quizzes_bank');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function attachLink() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('quizzes_briefing_links');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function sendIds() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('quizzes_briefing_sheets');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function save() {

        $jinput = JFactory::getApplication()->input;
        $respondents = $jinput->get('uids', NULL, 'RAW');
        $url = $jinput->get('url', NULL, 'RAW');
        $intro = $jinput->get('intro', NULL, 'RAW');
        $matchingAll = $jinput->get('allMatching', 0, 'INT');
        $countries = $jinput->get('countries', NULL, 'RAW');

        $_respondents = explode("|", $respondents);
        $question_answer = explode("-", $_respondents[0]);

        $date = date('Y-m-d H:i:s');

        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $columns = array('url', 'intro', 'countries', 'respondents', 'matching_all', 'date');

        $values = array($db->quote($url), $db->quote($intro), $db->quote(serialize($countries)), $db->quote($respondents), $db->quote($matchingAll), $db->quote($date));

        $query
                ->insert($db->quoteName('#__briefings'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));

        $db->setQuery($query);

        $send = $db->execute();

        die($send);
    }

    public function saveBriefing() {

        $jinput = JFactory::getApplication()->input;
        $ips = $jinput->get('ips', NULL, 'RAW');
        $title = $jinput->get('title', NULL, 'RAW');
        $intro = $jinput->get('intro', NULL, 'RAW');
        $signoff = $jinput->get('signoff', 0, 'RAW');
        $fid = $jinput->get('fid', 0, 'INT');

        $date = date('Y-m-d H:i:s');

        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        if ($fid === 0) {
            $columns = array('ip_address', 'title', 'intro', 'signoff', 'date_created');
            $values = array($db->quote(serialize($ips)), $db->quote($title), $db->quote($intro), $db->quote($signoff), $db->quote($date));

            $query
                    ->insert($db->quoteName('#__briefings_form'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $values));
        } else {

            $fields = array(
                $db->quoteName('ip_address') . ' = ' . $db->quote(serialize($ips)),
                $db->quoteName('title') . ' = ' . $db->quote($title),
                $db->quoteName('intro') . ' = ' . $db->quote($intro),
                $db->quoteName('signoff') . ' = ' . $db->quote($signoff),
                $db->quoteName('date_updated') . ' = ' . $db->quote($date)
            );

            $conditions = array(
                $db->quoteName('id') . ' = ' . $fid
            );

            $query
                    ->update($db->quoteName('#__briefings_form'))
                    ->set($fields)
                    ->where($conditions);
        }

//        echo $query->__toString();
        $db->setQuery($query);
        $send = $db->execute();

//        echo $send;

//        echo $db->stderr();
//        
//        echo $fid;
//        die;
//        echo $fid;
//        echo $send;
//        $data = array('title'=>$title, 'forms'=>$this->emailReviewsForms());                
//        
//        echo json_encode( $data );
        $this->emailReviewsForms();

        die;
    }

    public function emailReviewsForms() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('emailbuilder_email_review');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function _saveBriefing() {

        $jinput = JFactory::getApplication()->input;
        $url = $jinput->get('url', NULL, 'RAW');
        $intro = $jinput->get('intro', NULL, 'RAW');
        $bid = $jinput->get('bid', NULL, 'RAW');

        $date = date('Y-m-d H:i:s');

        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $fields = array(
            $db->quoteName('url') . ' = ' . $db->quote($url),
            $db->quoteName('intro') . ' = ' . $db->quote($intro),
            $db->quoteName('date_updated') . ' = ' . $db->quote($date),
        );

        $conditions = array(
            $db->quoteName('id') . ' = ' . $bid
        );

        $query
                ->update($db->quoteName('#__briefings'))
                ->set($fields)
                ->where($conditions);

        $db->setQuery($query);

        $send = $db->execute();

        die($send);
    }

    public function update() {

        $jinput = JFactory::getApplication()->input;

        $id = $jinput->get('bid', NULL, 'RAW');
        $respondents = $jinput->get('uids', NULL, 'RAW');
        $url = $jinput->get('url', NULL, 'RAW');
        $intro = $jinput->get('intro', NULL, 'RAW');
        $matchingAll = $jinput->get('allMatching', 0, 'INT');
        $countries = $jinput->get('countries', NULL, 'RAW');

        $_respondents = explode("|", $respondents);
        $question_answer = explode("-", $_respondents[0]);

        $date = date('Y-m-d H:i:s');

        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $fields = array(
            $db->quoteName('url') . ' = ' . $db->quote($url),
            $db->quoteName('intro') . ' = ' . $db->quote($intro),
            $db->quoteName('countries') . ' = ' . $db->quote(serialize($countries)),
            $db->quoteName('respondents') . ' = ' . $db->quote($respondents),
            $db->quoteName('matching_all') . ' = ' . $db->quote($matchingAll),
            $db->quoteName('date_updated') . ' = ' . $db->quote($date)
        );

        $conditions = array(
            $db->quoteName('id') . ' = ' . $id
        );

        $query
                ->update($db->quoteName('#__briefings'))
                ->set($fields)
                ->where($conditions);

        $db->setQuery($query);

        $send = $db->execute();

        die($send);
    }

    public function getBriefingDetails() {
        $model = $this->getModel('Backend');

        $view = $this->getView('backend', 'html');
        $view->setLayout('briefing_edit');
        $view->setModel($model, false);
        $view->display();

        die;
    }

    public function getFormDetails() {
        $jinput = JFactory::getApplication()->input;
        $fid = $jinput->get('fid', NULL, 'INT');

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__briefings_form');
        $query->where($db->quoteName('id') . " = " . $fid);

        $db->setQuery((string) $query);

        $briefingForm = $db->loadObject();

        $_form = array();
        $_form['id'] = $briefingForm->id;
        $_form['ipaddress'] = unserialize($briefingForm->ip_address);
        $_form['title'] = $briefingForm->title;
        $_form['intro'] = $briefingForm->intro;
        $_form['signoff'] = $briefingForm->signoff;

        $form = json_encode($_form);

        echo $form;
        die;
    }

    public function deleteLinkReview() {
        $jinput = JFactory::getApplication()->input;
        $lid = $jinput->get('lid', NULL, 'INT');

        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $conditions = array(
            $db->quoteName('id') . ' = ' . $lid
        );

        $query->delete($db->quoteName('#__briefings'));
        $query->where($conditions);

        $db->setQuery($query);

        $send = $db->execute();

        echo $send;
        die;
    }

    public function sendAll() {
        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $date = date('Y-m-d H:i:s');

        $fields = array(
            $db->quoteName('status') . ' = 2',
            $db->quoteName('date_mailed') . ' = ' . $db->quote($date)
        );

        $conditions = array(
            $db->quoteName('status') . ' = 0'
        );

        $query
                ->update($db->quoteName('#__briefings'))
                ->set($fields)
                ->where($conditions);

        $db->setQuery($query);

        $send = $db->execute();

        die($send);
    }

    public function send() {
        $model = $this->getModel('Backend');
        $jinput = JFactory::getApplication()->input;
        $bid = $jinput->get('bid', NULL, 'INT');

        $emails = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $briefing = $model->getBriefingFormDetails($bid);

        $countries = unserialize($briefing->ip_address);

        $ips = (array) $model->getSubmissionsIp();


        foreach ($ips as $_ip) {
            $ccode = $model->getIpInfo($_ip->UserIp);
            if (in_array(strtolower(trim($ccode)), array_map('strtolower', array_map('trim', $countries)))) {
                $user = JFactory::getUser($_ip->UserId);

                $emails[$_ip->UserId]['email'] = $user->email;
                $emails[$_ip->UserId]['name'] = $user->name;
            }
        }

        $model->getEmailContent($bid, $emails);

        $date = date('Y-m-d H:i:s');

        $fields = array(
            $db->quoteName('status') . ' = 2',
            $db->quoteName('date_mailed') . ' = ' . $db->quote($date)
        );

        $conditions = array(
            $db->quoteName('status') . ' = 0'
        );

        $query
                ->update($db->quoteName('#__briefings'))
                ->set($fields)
                ->where($conditions);

        $db->setQuery($query);

        $send = $db->execute();

        die($send);
    }

    public function getIpInfo() {
        $jinput = JFactory::getApplication()->input;

        $model = $this->getModel('Backend');
        $country_code = $jinput->get('ccode', NULL);

        $_ips = $model->getSubmissionsIp();

        $ips = array();
        $count = 0;

        foreach ($_ips as $ip) {
            $ccode = $model->getIpInfo($ip->UserIp);

            if (in_array(strtolower($ccode), array_map('strtolower', $country_code)) && !isset($ips[$ip->UserIp])) {
                $ips[$ip->UserIp] = $ccode;

                $count++;
            }
        }

        echo $count;
        die;
    }

    public function deleteBriefing() {
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->get('bid', NULL, 'INT');

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $conditions = array(
            $db->quoteName('id') . ' = ' . $id
        );

        $query->delete($db->quoteName('#__briefings_form'));
        $query->where($conditions);

        $db->setQuery($query);

        $result = $db->execute();

        echo $result;
        die;
    }

    public function countLinkReviews(){
        $model = $this->getModel('Backend');
        $linkReviews = $model->getLinkReviews();
        
        echo count($linkReviews);
        die;
    }
    
    public function countEmailReviews(){
        $model = $this->getModel('Backend');
        $emailReviews = $model->getBriefingForms();
        
        echo count($emailReviews);
        die;
    }
    
    public function countArchives(){
        $model = $this->getModel('Backend');
        $archives = $model->getArchives();
        
        echo count($archives);
        die;
    }
}
