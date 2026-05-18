<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private string          $fromEmail,
        private string          $toEmail,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMailContact($data): void
    {
        $email = (new Email())
            ->from($this->fromEmail)
            ->to($this->toEmail)
            ->subject('Site - Demande de contact')
            ->html(
                sprintf(
                    '<p>Bonjour,</p>
                         <p>Vous avez une nouvelle demande de contact :</p>
                         <ul>
                            <li>Nom : %s %s</li>
                            <li>Téléphone : %s</li>
                            <li>E-mail : %s</li>
                            <li>Message : %s</li>
                         </ul>
                         <p>Bonne réception</p>',
                    htmlspecialchars($data['prenom'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                    htmlspecialchars($data['nom'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                    htmlspecialchars($data['telephone'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                    htmlspecialchars($data['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                    nl2br(htmlspecialchars($data['message'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'))
                )
            );

        $this->mailer->send($email);
    }
}