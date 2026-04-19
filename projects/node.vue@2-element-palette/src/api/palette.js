const key = "palette";
export const is = () => { return window.localStorage.getItem(key) ? true : false; };
export const has = () => { };
export const can = () => { };
export const create = (_list = []) => { window.localStorage.setItem(key, JSON.stringify(_list)); };
export const drop = () => { window.localStorage.removeItem(key); };
export const insert = (item) => {
    const _list = list();
    _list.push(item);
    create(_list);
};
export const del = (index) => {
    const _list = list();
    _list.splice(index, 1);
    create(_list);
};
export const update = (index, item) => {
    const _list = list();
    _list.splice(index, 1, item);
    create(_list);
};
export const list = () => {
    return JSON.parse(window.localStorage.getItem(key));
};
export const info = (index) => {
    const _list = list();
    return _list[index];
};
export const item = () => { };