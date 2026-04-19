<template>
    <el-row :gutter="20" style="margin-left:0;margin-right:0;">
        <h1>{{single.name}}</h1>
        <el-col :span="4" class="el-col__color" v-for="(value,key) in single.children" :key="key">
            <el-card class="el-card__color" :style="{'background':value.color}">
                <span>{{value.name}}：{{value.color}}</span>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
export default {
    data() {
        return {};
    },
    created() {
        this.$store.dispatch("loadChildren", {
            type: "single",
            key: this.$route.params.key
        });
    },
    computed: {
        single() {
            let _key = this.$route.params.key;
            return this.$store.getters.single(_key);
        }
    }
};
</script>

<style scoped>
.color-box {
    height: 150px;
}
.box-card {
    height: 150px;
    border-radius: 10px;
}
.box-card .el-card__body {
    padding: 0 0 20px 0;
}
.box-card span {
    display: none;
    color: white;
}
.box-card:hover span {
    display: block;
}
</style>