//requires byte string functions.
$(document).ready(function () {
    $('#UserDetailsQuota').html(getByteString($('#UserDetailsQuota').html()));
    $('#UserDetailsUsedSpace').html(getByteString($('#UserDetailsUsedSpace').html()));
    $('#UserDetailsFreeSpace').html(getByteString($('#UserDetailsFreeSpace').html()));
});