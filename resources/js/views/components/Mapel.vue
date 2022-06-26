<template>
  <div>
    {{value}}
    <Kelas v-model="value" />
  </div>
</template>
<script>
import Kelas from "./Kelas";
export default {
  props: {
        value:{},
  },
  components: {
    Kelas
  },
};
</script>
