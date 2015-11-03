function getByteString(bytes) {
    var divisible = true;
    var divided = 0;
    while (divisible) {
        if (bytes > 999) {
            bytes = bytes / 1000;
            divided++;
        }
        else { divisible = false; }
    }
	bytes = Math.round(bytes * 100) / 100;
    switch (divided) {
        case 0:
            return bytes + ' B';
            break;
        case 1:
            return bytes + ' KB';
            break;
        case 2:
            return bytes + ' MB';
            break;
        case 3:
            return bytes + ' GB';
            break;
        default:
            return bytes + ' GB';
    }
}
function getBytes(byteString) {
    var byteSplit = byteString.split(" ");
    switch (byteSplit[1]) {
        case 'B': return byteSplit[0];
        case 'KB': return byteSplit[0] * 1000;
        case 'MB': return byteSplit[0] * 1000 * 1000;
        case 'GB': return byteSplit[0] * 1000 * 1000 * 1000;
        default: return byteSplit[0];
    }
}