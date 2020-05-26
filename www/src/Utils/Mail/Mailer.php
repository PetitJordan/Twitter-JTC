<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 12/11/2018
 * Time: 15:18
 */

namespace App\Utils\Mail;

use App\Utils\Various\Constant;
use Symfony\Component\HttpKernel\KernelInterface;

class Mailer
{
    const MAILJET_API_KEY_TRANSACTIONAL = Constant::MAILJET_API_KEY_TRANSACTIONAL;
    const MAILJET_API_SECRET_TRANSACTIONAL = Constant::MAILJET_API_SECRET_TRANSACTIONAL;
    const NO_REPLY_EMAIL = Constant::NO_REPLY_EMAIL;
    const CONTACT_EMAIL = Constant::CONTACT_EMAIL;
    const NO_REPLY_NAME = Constant::NO_REPLY_NAME;


    const USER_REGISTER = 100;
    const CONTACT = 300;
    const JOB = 800;

    protected $mailer;
    protected $twig;
    protected $kernel;

    private $from = self::NO_REPLY_EMAIL;
    private $fromName = self::NO_REPLY_NAME;
    private $templatesFolder = 'mails/';
    private $siteType;

    public function __construct(
        \Swift_Mailer $mailer,
        \Twig_Environment $twig,
        KernelInterface $kernel
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->kernel = $kernel;

        $this->setSiteType($this->kernel->getEnvironment());
    }

    public function send($type, $to, $params = array(), $headers = array())
    {
        //-------------------------------------------------------------------
        // parmètres
        $subject = '';
        $template = '';
        $tags55 = array();
        $utm_array = array(
            'utm_source' => '',
            'utm_medium' => '',
            'utm_campaign' => '',
        );
        $utm_str = '';

        //-------------------------------------------------------------------
        // selon le type de message
        switch ($type) {
            case self::USER_REGISTER:
                $params['subject'] = 'Bienvenu';
                $subject = $params['subject'];

                $template = 'user/welcome.html.twig';

                $utm_array['utm_source'] = '';
                $utm_array['utm_medium'] = '';
                $utm_array['utm_campaign'] = '';
                break;

            case self::CONTACT:
                $params['subject'] = '[Digital Start] Contact sur le site Digital Start';
                $subject = $params['subject'];
                $headers['Mj-campaign'] = $this->siteType.'_contact_'.date('Y_m');

                $template = 'contact/contact.html.twig';


                $utm_array['utm_source'] = '';
                $utm_array['utm_medium'] = '';
                $utm_array['utm_campaign'] = '';
                break;

            case self::JOB:
                $params['subject'] = 'Candidature d\'emploi sur le site Digital Start';
                $subject = $params['subject'] .'-'. $params['jobId'];
                $headers['Mj-campaign'] = $this->siteType.'_contact_'.date('Y_m');

                $template = 'job/job.html.twig';


                $utm_array['utm_source'] = '';
                $utm_array['utm_medium'] = '';
                $utm_array['utm_campaign'] = '';
                break;

            default:
                throw new \BadMethodCallException();
                break;
        }

        //-------------------------------------------------------------------
        // paramètres utm
        foreach ($utm_array as $key => $value) {
            $utm_str .= '&'.$key.'='.$value;
        }
        $params['utm_str'] = $utm_str;

        //-------------------------------------------------------------------
        // Envoi du message

        $message = (new \Swift_Message($subject))
            ->setTo($to)
            ->setFrom($this->getFrom(), $this->getFromName())
            ->setBody($this->twig->render($this->templatesFolder.$template, $params), 'text/html');
        if (isset($params['replyTo']) && $params['replyTo']) {
            $message->setReplyTo($params['replyTo']);
        }
        if (isset($params['attachmentPath']) && isset($params['attachmentFilename'])) {
            $message->attach(\Swift_Attachment::fromPath($params['attachmentPath'])->setFilename($params['attachmentFilename']));
        }

        if (is_array($headers) && count($headers)) {
            foreach ($headers as $key => $value) {
                $message->getHeaders()->addTextHeader($key, $value);
            }
        }

        return $this->mailer->send($message);
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     */
    public function setFromName(string $fromName): void
    {
        $this->fromName = $fromName;
    }

    /**
     * @return mixed
     */
    public function getSiteType()
    {
        return $this->siteType;
    }

    /**
     * @param mixed $siteType
     */
    public function setSiteType($siteType): void
    {
        $this->siteType = $siteType;
    }
}
