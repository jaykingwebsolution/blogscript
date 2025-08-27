@extends('admin.layout')

@section('title', 'Create User')
@section('header', 'Create User')

@section('content')
<div class="mb-6">
    <div class="flex items-center">
        <a href="{{ route('admin.users.index') }}" class="text-spotify-green hover:text-spotify-green-light mr-4">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-xl font-semibold text-white">Create New User</h2>
    </div>
</div>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-gray-50 dark:bg-gray-900 shadow rounded-lg p-6">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Info -->
            <div>
                <label for="name" class="block text-sm font-medium text-white mb-2">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                       placeholder="Enter full name">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-white mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                       placeholder="user@example.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-white mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                       placeholder="Enter password">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-white mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                       placeholder="Confirm password">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-white mb-2">Role</label>
                <select id="role" name="role" required
                        class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none">
                    <option value="">Select Role</option>
                    <option value="listener" {{ old('role') == 'listener' ? 'selected' : '' }}>Listener</option>
                    <option value="artist" {{ old('role') == 'artist' ? 'selected' : '' }}>Artist</option>
                    <option value="record_label" {{ old('role') == 'record_label' ? 'selected' : '' }}>Record Label</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-white mb-2">Status</label>
                <select id="status" name="status" required
                        class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none">
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            <div>
                <label for="country" class="block text-sm font-medium text-white mb-2">Country</label>
                <select id="country" name="country"
                        class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none">
                    <option value="">Select Country</option>
                    @foreach(config('countries.countries') as $code => $country)
                        <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>
                            {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="state" class="block text-sm font-medium text-white mb-2">State/Province</label>
                <select id="state" name="state"
                        class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                        disabled>
                    <option value="">Select State/Province</option>
                </select>
            </div>
        </div>

        <!-- Artist-specific fields -->
        <div id="artist-fields" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6" style="display: none;">
            <div>
                <label for="artist_stage_name" class="block text-sm font-medium text-white mb-2">Stage Name</label>
                <input type="text" id="artist_stage_name" name="artist_stage_name" value="{{ old('artist_stage_name') }}"
                       class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                       placeholder="Enter stage name">
            </div>

            <div>
                <label for="artist_genre" class="block text-sm font-medium text-white mb-2">Genre</label>
                <input type="text" id="artist_genre" name="artist_genre" value="{{ old('artist_genre') }}"
                       class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                       placeholder="Hip Hop, R&B, Pop">
            </div>
        </div>

        <div class="mt-6">
            <label for="bio" class="block text-sm font-medium text-white mb-2">Bio</label>
            <textarea id="bio" name="bio" rows="4" 
                      class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                      placeholder="Tell us about this user...">{{ old('bio') }}</textarea>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-spotify-black text-white border border-spotify-light-gray rounded-lg hover:bg-spotify-gray transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-spotify-green text-white rounded-lg hover:bg-spotify-green-light transition-colors">
                Create User
            </button>
        </div>
    </form>
</div>

<script>
// Country and State data
const countryStates = @json(config('countries.countries'));

document.getElementById('role').addEventListener('change', function() {
    const artistFields = document.getElementById('artist-fields');
    if (this.value === 'artist' || this.value === 'record_label') {
        artistFields.style.display = 'block';
    } else {
        artistFields.style.display = 'none';
    }
});

document.getElementById('country').addEventListener('change', function() {
    const stateSelect = document.getElementById('state');
    const selectedCountry = this.value;
    
    // Clear existing options
    stateSelect.innerHTML = '<option value="">Select State/Province</option>';
    
    if (selectedCountry && countryStates[selectedCountry] && countryStates[selectedCountry].states) {
        const states = countryStates[selectedCountry].states;
        
        if (Object.keys(states).length > 0) {
            // Enable the state dropdown and populate it
            stateSelect.disabled = false;
            
            for (const [code, name] of Object.entries(states)) {
                const option = document.createElement('option');
                option.value = code;
                option.textContent = name;
                stateSelect.appendChild(option);
            }
        } else {
            // No states available for this country
            stateSelect.disabled = true;
        }
    } else {
        // No country selected or no states
        stateSelect.disabled = true;
    }
    
    // Restore selected state if editing
    const oldState = '{{ old('state') }}';
    if (oldState) {
        stateSelect.value = oldState;
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const role = document.getElementById('role').value;
    if (role === 'artist' || role === 'record_label') {
        document.getElementById('artist-fields').style.display = 'block';
    }
    
    // Trigger country change to populate states if country was selected
    const country = document.getElementById('country').value;
    if (country) {
        document.getElementById('country').dispatchEvent(new Event('change'));
    }
});
</script>
@endsection