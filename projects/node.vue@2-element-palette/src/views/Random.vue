<template>
    <el-row
        :gutter="20"
        style="margin-left:0;margin-right:0;height:100vh;"
        :style="{'background-color':color}"
        @click.native="random"
    >
        <h1 style="color:white;">随机色 - {{color}}</h1>
    </el-row>
</template>

<script>
export default {
    data() {
        return {
            color: ""
        };
    },
    created() {
        this.random();
    },
    methods: {
        random() {
            let _c = "#";
            let _def = [
                0,
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                "A",
                "B",
                "C",
                "D",
                "E",
                "F"
            ];
            let len = _def.length;
            for (let i = 0; i < 6; i++) {
                _c += _def[parseInt(Math.random() * len)];
            }
            this.$data.color = _c;
        }
    }
};
</script>

<style scoped>
</style>