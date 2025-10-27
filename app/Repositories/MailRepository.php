<?php

declare(strict_types=1);


namespace App\Repositories;

use App\Contracts\Query\QueryBuilderFactoryInterface;
use App\Contracts\Repositories\MailRepositoryInterface;
use App\DTOs\MailData;
use App\Enums\MailStatus;
use App\Models\Mail;
use App\Query\Param;

class MailRepository implements MailRepositoryInterface
{
    public function __construct(
        private readonly QueryBuilderFactoryInterface $queryBuilderFactory,
    ) {}

    public function createMail(MailData $mailData, MailStatus $mailStatus): Mail
    {
        $insert = $this->queryBuilderFactory
            ->createInsertQuery(
            "mail",
            ["to", "from", "from_name", "subject", "body", "status"],
        );

        $insert->values(Param::bindList([
            $mailData->to,
            $mailData->from,
            $mailData->fromName,
            $mailData->subject,
            $mailData->message,
            $mailStatus->value
        ]));

        $query = $insert->build()->execute();

        return new Mail(
            $query->lastInsertId(),
            $mailData->to,
            $mailData->from,
            $mailData->fromName,
            $mailData->subject,
            $mailData->message,
            MailStatus::QUEUED
        );
    }

    /**
     * @return Mail[]
     */
    public function getMailsByStatus(MailStatus $mailStatus): array
    {
        $select = $this->queryBuilderFactory
            ->createSelectQuery("mail", ["*"]);

        $select->where("status", Param::bind($mailStatus->value));

        $query = $select->build()->execute();
        $mails = $query->fetchAll();

        $mails = array_map(function ($mail) {
            return new Mail(
                $mail["id"],
                $mail["to"],
                $mail["from"],
                $mail["from_name"],
                $mail["subject"],
                $mail["body"],
                MailStatus::from($mail["status"])
            );
        }, $mails);

        return $mails;
    }

    public function updateMailStatus(Mail $mail, MailStatus $newStatus): Mail
    {
        $update = $this->queryBuilderFactory
            ->createUpdateQuery("mail");

        $update
            ->set("status", Param::bind($newStatus->value))
            ->where("id", Param::bind($mail->getId()));

        $query = $update->build()->execute();

        return $mail->setStatus($newStatus);
    }
}