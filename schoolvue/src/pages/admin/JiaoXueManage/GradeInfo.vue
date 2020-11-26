<template>
    <!--年级信息-->
  <div>
    <div>
      <el-breadcrumb separator-class="el-icon-arrow-right">
        <el-breadcrumb-item :to="{ path: '/admin/index' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>年级管理</el-breadcrumb-item>
      </el-breadcrumb>
      <el-divider></el-divider>
    </div>

  </div>
</template>

<script>
    export default {
        name: "GradeInfo"
    }
</script>

<style scoped>

</style>
