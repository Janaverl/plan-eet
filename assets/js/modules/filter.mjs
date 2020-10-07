function isLastActiveInArray(array) {
    if (array.filter(obj => obj.isActive).length > 1) {
        return false;
    } 
    return true;
}

export default {
    isLastActiveInArray
}