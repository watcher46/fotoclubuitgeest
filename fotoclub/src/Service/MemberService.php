<?php

namespace App\Service;

use App\Entity\Member;
use App\Repository\MemberRepository;

class MemberService
{
    /** @var MemberRepository */
    protected $memberRepo;

    public function __construct(
        MemberRepository $memberRepository
    )
    {
        $this->memberRepo = $memberRepository;
    }

    /**
     * @return Member[]
     */
    public function getAllActiveMembers()
    {
        return $this->memberRepo->findActiveMembers();
    }

    /**
     * @param int $id
     * @return Member|null
     */
    public function getMember(int $id)
    {
        return $this->memberRepo->find($id);
    }
}