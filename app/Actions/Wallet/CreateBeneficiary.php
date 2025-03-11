<?php
declare(strict_types = 1);
namespace App\Actions\Wallet;
use App\Models\Beneficiary;

final class CreateBeneficiary
{
    public function __invoke(\App\DTO\Paystack\Beneficiary $beneficiary)
	{
        $beneficiary_exists = Beneficiary::query()->where('user_id', auth()->id())->first();
        if( $beneficiary_exists == null)
        {
            $date = new \DateTime();
            $account_beneficiary = Beneficiary::create([
                'user_id' => auth()->id(),
                'account_name' => $beneficiary->account_name,
                'account_number' => $beneficiary->account_number,
                'bank_name' => $beneficiary->bank_name,
                'bank_code' => $beneficiary->bank_code,
                'recipient_code' => $beneficiary->recipient_code,
                'provider_id' => $beneficiary->id
            ]);
            return $account_beneficiary;
        }
        return $beneficiary_exists;
	}
}