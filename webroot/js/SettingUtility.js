var fieldCallbacks = new Object();
function catchArray(cArray, returnTo) {
    callBack(returnTo, cArray);
}
function registerCallback(name, callback){
    fieldCallbacks[name] = callback;
}
function callBack(name, param) {
    fieldCallbacks[name](param);
}