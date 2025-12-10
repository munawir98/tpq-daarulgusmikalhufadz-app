<?php

namespace App\Repositories\Contracts;

interface GroupMemberRepositoryInterface {
    public function members($groupId);
    public function addMember(array $data);
    public function removeMember($groupId, $userId);
}
