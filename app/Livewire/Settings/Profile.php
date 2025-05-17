<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;
    public string $name = '';
    public string $email = '';
    public string $dietaryPreference = '';
    public string $phoneNumber = '';
    public $originalProfilePicture = null;
    public $uploadedProfilePicture = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->dietaryPreference = Auth::user()->dietary_preference;
        $this->phoneNumber = Auth::user()->phone_number;
        $this->originalProfilePicture = Auth::user()->profile_picture;
        $this->uploadedProfilePicture = Auth::user()->upload;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validationRules = [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],

            'dietaryPreference' => ['required', 'string'],

            'phoneNumber' => [
                'required',
                'string',
                'regex:/^01[0-9]{1}-[0-9]{7,8}$/',
                'min:11',
                Rule::unique(User::class, 'phone_number')->ignore($user->id),
            ],
        ];

        if ($this->uploadedProfilePicture instanceof TemporaryUploadedFile) {
            $validationRules['uploadedProfilePicture'] = [
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ];
        }

        $validated = $this->validate($validationRules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->dietary_preference = $validated['dietaryPreference'];
        $user->phone_number = $validated['phoneNumber'];

        if ($this->uploadedProfilePicture instanceof TemporaryUploadedFile) {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $this->uploadedProfilePicture->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        $this->redirect(route('settings.profile', absolute: false));
        // $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    public function render()
    {
        return view('livewire.settings.profile');
    }
}
