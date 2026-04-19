import { palette as api_palette } from '@/api';
import * as palette_data from '@/data/palette';
export default {
    state: {
        _id: 0,
        item: palette_data.item(),
        dialog: {
            visible: false,
            target: "insert",// insert update
            index: null,
        },
        carousel: {
            visible: false,
            index: 0,
        },
        filter: {
            type: "all",
        },
        list: [],
        select: [],
        series: [],
    },
    mutations: {
        setPalette() { },
        setPaletteColor() { },
        setPaletteItem(state, index = undefined) {
            if (index == undefined) {
                state.item = palette_data.item(state._id);
            } else {
                state.item = JSON.parse(JSON.stringify(state.list[index]));
                state.dialog.index = index;
            }
        },
        setPaletteList(state, list) {
            state.list.splice(0, 0, ...list);
            state._id = list.reduce((total, val) => total > val.id ? total : val.id + 1, state._id);
        },
        addPaletteColor(state) {
            state.item.colors.push("");
        }
    },
    getters: {
        palette_list: (state) => {
            if (state.filter.type == 'all') {
                return state.list;
            } else {
                return state.list.filter(v => v.type === state.filter.type);
            }
        },
    },
    actions: {
        insertPalette({ state }) {
            state.item.id = state._id;
            state.list.push(JSON.parse(JSON.stringify(state.item)));
            api_palette.insert(state.item);
            state._id = state._id + 1;
        },
        deletePalette({ state }, index) {
            state.list.splice(index, 1);
            api_palette.del(index);
        },
        batchDeletePalette({ state },) {
            state.select.forEach(id => {
                for (let i = 0; i <= state.list.length - 1; i++) {
                    if (id === state.list[i].id) {
                        state.list.splice(i, 1);
                    }
                }
            })
            state.select = [];
            api_palette.create(state.list);
        },
        updatePalette({ state }) {
            state.list.splice(state.dialog.index, 1, JSON.parse(JSON.stringify(state.item)));
            api_palette.update(state.dialog.index, JSON.parse(JSON.stringify(state.item)));
        },
    }
}