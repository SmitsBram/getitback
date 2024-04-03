<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="bedrijfsnaam" :value="__('Bedrijfsnaam')" />
            <x-text-input id="bedrijfsnaam" name="bedrijfsnaam" type="text" class="mt-1 block w-full" :value="old('bedrijfsnaam', $user->bedrijfsnaam)" />
            <x-input-error class="mt-2" :messages="$errors->get('bedrijfsnaam')" />
        </div>

        <div>
            <x-input-label for="straat_en_huisnummer" :value="__('Straat en huisnummer')" />
            <x-text-input id="straat_en_huisnummer" name="straat_en_huisnummer" type="text" class="mt-1 block w-full" :value="old('straat_en_huisnummer', $user->straat_en_huisnummer)" />
            <x-input-error class="mt-2" :messages="$errors->get('straat_en_huisnummer')" />
        </div>

        <div>
            <x-input-label for="postcode" :value="__('Postcode')" />
            <x-text-input id="postcode" name="postcode" type="text" class="mt-1 block w-full" :value="old('postcode', $user->postcode)" />
            <x-input-error class="mt-2" :messages="$errors->get('postcode')" />
        </div>

        <div>
            <x-input-label for="plaats" :value="__('Plaats')" />
            <x-text-input id="plaats" name="plaats" type="text" class="mt-1 block w-full" :value="old('plaats', $user->plaats)" />
            <x-input-error class="mt-2" :messages="$errors->get('plaats')" />
        </div>

        <div>
            <x-input-label for="land" :value="__('Land')" />
            <x-text-input id="land" name="land" type="text" class="mt-1 block w-full" :value="old('land', $user->land)" />
            <x-input-error class="mt-2" :messages="$errors->get('land')" />
        </div>

        <div>
            <x-input-label for="kvknummer" :value="__('KVKnummer')" />
            <x-text-input id="kvknummer" name="kvknummer" type="text" class="mt-1 block w-full" :value="old('kvknummer', $user->kvknummer)" />
            <x-input-error class="mt-2" :messages="$errors->get('kvknummer')" />
        </div>

        <div>
            <x-input-label for="telefoonnummer" :value="__('Telefoonnummer')" />
            <x-text-input id="telefoonnummer" name="telefoonnummer" type="text" class="mt-1 block w-full" :value="old('telefoonnummer', $user->telefoonnummer)" />
            <x-input-error class="mt-2" :messages="$errors->get('telefoonnummer')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
