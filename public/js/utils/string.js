function stripIdWithClassname(element, classname) {
    const fullId = $(element).prop('id');
    return fullId.replace(classname+"-", ""); 
}

export default {
    stripIdWithClassname
}