<template>
  <nav>
    <ul v-if="links && links.length > 3" class="pagination">
      <li v-for="link in links" class="page-item">
        <span
            :class="[parseInt(link.label) === parseInt(props.current) ? 'active' : '']" @click="navClick(link.page)"
            class="page-link"
            v-html="link.label">
        </span>
      </li>
    </ul>
  </nav>

</template>

<script setup lang="ts">
import { computed } from 'vue'


const props = defineProps<{ links: Array<any>, current: number, lastPage: number}>()
const emit = defineEmits(['navClick'])

const links = computed(() => {
    return props.links.map((link) => ({
        ...link,
        label: link.label,
        page: link.label,
        active: link.active ?? false,
    }));
});


function navClick(page:string){

  if((page === "Next &raquo;") && props.current === props.lastPage){
    return
  }

  if((page === "&laquo; Previous") && props.current === 1){
    return
  }

  if(page === "&laquo; Previous"){
    page = (props.current - 1).toString();
  }

  if(page === "Next &raquo;"){
    page = (props.current + 1).toString();
  }

  emit('navClick', page);
}

</script>

<style lang="scss" scoped>
@import "./../../../css/variables.scss";

.pagination{
    list-style-type: none;
    display: flex;
 }

.pagination span{
  cursor: pointer;
    padding: 5px 8px;
    margin-right: 1px;
  color: #111;
}

.pagination span.active{
  background-color: $primaryColor;
  border-radius: 3px;
  border: 1px solid $primaryColor;
  color: #fff;
}

.pagination span:hover{
  color: $primaryDarkColor;
}

.pagination span.active:hover{
  color: #fff;
}

</style>
