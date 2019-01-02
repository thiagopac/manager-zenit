<template>
    <VuePerfectScrollbar class="scroll-area2" :settings="settings">
      <div class="drag-container">	
          <ul class="drag-list">
          		<li v-for="(stage, index) in stages" class="drag-column" :class="{['drag-column-' + stage.id]: true}" :index="index" :data-stage-id="stage.id" :data-stage-order="stage.order" :key="stage.order">
          			<span class="drag-column-header" :style="'border-color:'+stage.color">
          				<h2 class="tippy" :title="stage.name">{{ stage.name }} 
                      <br/> 
                      <small>{{ getBlockCounts(stage) }} Leads</small>
                  </h2>
                  <slot :name="stage.name"></slot>
          			</span>
          			<div class="drag-options"></div>
                <VuePerfectScrollbar class="scroll-area" :settings="settings">
              			<ul class="drag-inner-list" ref="list" :data-status="stage.id">
                              <li class="drag-item" v-for="block in getBlocks(stage)" :data-block-id="block.id" :data-block-order="block.order" :key="block.id">
                                  <slot :name="block.id">
                                      <strong>{{ block.status }}</strong>
                                      <div>{{ block.id }}</div>
                                  </slot>
                              </li>   
              			</ul>
                    <div v-if="getBlockCounts(stage) > stage.limit" class="stage-load-more">
                      <button class="btn" @click="loadMore(index)">Load More...</button>
                    </div>
                </VuePerfectScrollbar>
          		</li>
    	   </ul>
        
              
    </div>
  </VuePerfectScrollbar>
</template>

<script>
import dragula from "dragula";
import VuePerfectScrollbar from "vue-perfect-scrollbar";
var _ = require("lodash");

export default {
  name: "KanbanBoard",
  components: {
    VuePerfectScrollbar
  },
  props: {
    stages: {},
    blocks: {},
    settings: {
      maxScrollbarLength: 40
    }
  },

  computed: {
    localBlocks() {
      return this.blocks;
    }
  },

  methods: {
    getBlocks(status) {
      var listPaginate = this.localBlocks.filter(block => block.status_id === status.id);

      if (listPaginate != "" && status.id != 0 && status.limit < listPaginate.length) {
        listPaginate = listPaginate.setOffset(status.offset).setMax(status.limit);
      }

      return listPaginate;
    },
    getBlock(id) {
      var block_id = id;
      function findBlock(block) {
        return block.id === Number(block_id);
      }
      return this.localBlocks.find(findBlock);
    },
    loadMore(i) {
      this.stages[i].limit = this.stages[i].limit + 50;
    },
    getBlockCounts(status) {
      return this.localBlocks.filter(block => block.status_id === status.id).length;
    }
  },
  updated() {
    this.$nextTick(function() {
      /* reload tippy on dom change */
      tippy(".tippy", {
        theme: "blueline",
        animation: "shift",
        size: "big",
        arrow: true
      });
    });
  },
  mounted() {
    dragula(this.$refs.list, { grabDelay: 2000 })
      .on("drag", el => {
        el.classList.add("is-moving");
        $(".drag-column-options").addClass("active");
      })
      .on("drop", (block, list, prevList, sibling) => {
        if (sibling != null) {
          //var previous_block_order = $(sibling.previousSibling).data("block-order");
          var next_block_order = $(sibling).data("block-order");
          var current_block_order = next_block_order - 0.1;
        } else {
          var lastone,
            index = this.getBlocks(list).length - 1;
          for (; index >= 0; index--) {
            if (this.getBlocks(list)[index].status_id == list.dataset.status) {
              lastone = this.getBlocks(list)[index];
              break;
            }
          }

          current_block_order = typeof lastone != "undefined" ? lastone.order + 1 : 15;
        }

        block.dataset.blockOrder = current_block_order;

        if (list.dataset.status == "options") {
          this.$emit("delete-block", block.dataset.blockId, prevList.dataset.status);
        } else {
          this.$emit("update-block", block.dataset.blockId, list.dataset.status, current_block_order);
        }
      })
      .on("over", (el, container, source) => {
        if ($(container).data("status") == "options") {
          $(".drag-item.is-moving.gu-mirror").addClass("wobble");
        } else {
          $(".drag-item.is-moving.gu-mirror").removeClass("wobble");
        }
      })
      .on("dragend", el => {
        el.classList.remove("is-moving");

        window.setTimeout(() => {
          el.classList.add("is-moved");
          window.setTimeout(() => {
            el.classList.remove("is-moved");
            $(".drag-column-options").removeClass("active");
          }, 600);
        }, 100);
      });
  }
};
</script>

<style lang="css" scoped>
.scroll-area {
  position: relative;
  margin: auto;
  height: calc(100vh - 200px);
}
.scroll-area2 {
  position: relative;
  margin: auto;
  width: 100%;
}
.modal-open .content-area {
  position: absolute;
}
</style>
