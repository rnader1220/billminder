<div id="modal"x-data="{ showHelp: false }" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-[80%] p-6 relative">
        <div class="container mx-auto px-4">
            <span id="modal_title"></span>
            <div class="flex justify-end mb-4" id="btn-group-head">
                <button type="button" id="control_edit" class="btn btn-warning mr-2"><i
                        class='fa-solid fa-edit mr-1'></i>Change</button>

                <button type="button" id="control_delete" class="btn btn-danger mr-2"><i
                        class='fa-solid fa-trash mr-1'></i>Delete</button>
            </div>

        </div>

        <div id="modal_content" class="overflow-y-auto max-h-[65vh]">
            <!-- Injected HTML goes here -->
        </div>
        <div class="container mx-auto px-4">
            <div class="flex justify-end mb-4" id="btn-group-foot">

                <button type="button" id="control_help" @click="showHelp = !showHelp" class="btn btn-secondary mr-2"><i
                        class='fa-solid fa-person-drowning mr-1'></i>Help</button>

                <button type="button" id="control_save" class="btn btn-success mr-2"><i
                        class='fa-solid fa-floppy-disk-pen mr-1'></i>Save</button>

                <button type="button" id="control_cancel" class="btn btn-secondary mr-2"><i
                        class='fa-solid fa-backward mr-1'></i>&nbsp;Cancel</button>

                <button type="button" id="control_close" class="btn btn-secondary mr-2"><i
                        class='fa-solid fa-xmark mr-1'></i>Close</button>
            </div>
        </div>
    </div>
</div>