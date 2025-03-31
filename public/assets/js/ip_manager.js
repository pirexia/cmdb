$(document).ready(function() {
    let ipEntryCounter = 1;
    
    $('#add-ip-entry').click(function() {
        const newEntry = $('#ip-entries .ip-entry:first').clone();
        const newIndex = ipEntryCounter++;
        
        newEntry.find('[name]').each(function() {
            const name = $(this).attr('name').replace(/\[\d+\]/, `[${newIndex}]`);
            $(this).attr('name', name).val('');
        });
        
        newEntry.find('.btn-remove-ip').show();
        $('#ip-entries').append(newEntry);
    });
    
    $(document).on('click', '.btn-remove-ip', function() {
        if ($('#ip-entries .ip-entry').length > 1) {
            $(this).closest('.ip-entry').remove();
        }
    });
    
    $('form').submit(function() {
        let valid = true;
        $('.ip-address').each(function() {
            const ip = $(this).val();
            if (ip && !isValidIP(ip)) {
                alert(`La IP ${ip} no tiene un formato válido`);
                valid = false;
                return false;
            }
        });
        return valid;
    });
    
    function isValidIP(ip) {
        return /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/.test(ip) || 
               /^(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)$/.test(ip);
    }
});