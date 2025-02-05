<div class="mt-4 hidden">
    <x-input-label for="roles" :value="__('Role')" />
    <select wire:model="roles" id="roles" class="block mt-1 w-full" name="roles">
        <option value="" disabled selected>-- Select Role --</option>
        <option value="1">Admin</option>
        <option value="2">Dokter</option>
        <option value="3">Masyarakat</option>
    </select>
    <x-input-error :messages="$errors->get('roles')" class="mt-2" />
</div>
