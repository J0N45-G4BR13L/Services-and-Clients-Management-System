<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Event\BeforeSave;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;

use App\Filament\Resources\ClienteResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

use Illuminate\Support\Facades\Auth;


class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getCaptalizedName(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data')
            ),
        ];
    }
    public function getCaptalizedName()
    {
        return Forms\Components\TextInput::make('name')
            ->label('Nome')
            ->required()
            ->dehydrateStateUsing(fn ($state) => ucwords($state));
    }

    
    
    
    
    
}
