
    <div class="form-check form-check-inline m-2 ">
        <label class="radio-inline">
            <input type="radio" wire:click="edit_status" wire:model="value" name="nota" value="{{$status->id}}" class="radio"
                style="opacity: 0; position: absolute;" />
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="{{$fill_color}}"
                class="bi bi-emoji-smile-fill" viewBox="0 0 16 16">
                <path d="{{$status->icon}}"></path>
            </svg>
        </label>
    </div>

    

