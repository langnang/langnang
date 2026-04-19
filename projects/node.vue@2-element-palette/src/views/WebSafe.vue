<template>
    <el-row :gutter="20" style="margin-left:0;margin-right:0;">
        <h1>216 Web安全色</h1>
        <span v-for="(R,iR) in colors" :key="iR">
            <span v-for="(G,iG) in colors" :key="iG">
                <span v-for="(B,iB) in colors" :key="iB">
                    <el-col :span="4" class="el-col__color">
                        <el-card class="el-card__color" :style="{'background-color':'#'+R+G+B}">
                            <span style="line-height:110px;">#{{R}}{{G}}{{B}}</span>
                        </el-card>
                    </el-col>
                </span>
            </span>
        </span>
    </el-row>
</template>

<script>
export default {
    data() {
        return {
            colors: ["00", "33", "66", "99", "CC", "FF"]
        };
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