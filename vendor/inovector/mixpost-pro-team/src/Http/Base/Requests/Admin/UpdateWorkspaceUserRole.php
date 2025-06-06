<?php

namespace Inovector\Mixpost\Http\Base\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Inovector\Mixpost\Concerns\UsesUserModel;
use Inovector\Mixpost\Enums\WorkspaceUserRole;
use Inovector\Mixpost\Models\Workspace;

class UpdateWorkspaceUserRole extends FormRequest
{
    use UsesUserModel;

    public function rules(): array
    {
        return [
            'user_id' => ['required', "exists:" . app(self::getUserClass())->getTable() . ",id"],
            'role' => ['required', Rule::in(Arr::map(WorkspaceUserRole::cases(), fn($item) => $item->value))],
            'can_approve' => ['required', 'boolean'],
        ];
    }

    public function handle()
    {
        $workspace = Workspace::firstOrFailByUuid($this->route('workspace'));

        $workspace->users()->updateExistingPivot($this->input('user_id'), [
            'role' => $this->input('role'),
            'can_approve' => $this->input('can_approve', false),
        ]);
    }
}
