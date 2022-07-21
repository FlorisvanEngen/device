<div id="deleteDeviceModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete a device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the device "<span id="deviceName"></span>" (<span id="deviceId"></span>)</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="deviceDeleteButton" type="button" class="btn btn-danger">Delete</button>
                <form id="deleteDevice" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
