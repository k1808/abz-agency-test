import {acceptHMRUpdate, defineStore} from 'pinia'
import axios from "axios";
import { ref, watch } from "vue";
import {useLangStore} from "~/stores/LangStore";

export const useJournalStore = defineStore('JournalStore', () => {
    const topPages= ref([])
    const loader = ref(true)
    const pages= ref([])
    const pagination = ref({})
    const pageItem = ref({})
    const recommendPages= ref([])
    const appConfig = useAppConfig()
    const  langStore = useLangStore()

    if (typeof window !== 'undefined') {
        const paginationPagesInLocalStorage = localStorage.getItem("paginationJournal");
        if (paginationPagesInLocalStorage) {
            pagination.value = JSON.parse(paginationPagesInLocalStorage)._value;
        }

        const recommendPagesInLocalStorage = localStorage.getItem("recommendPages");
        if (recommendPagesInLocalStorage) {
            recommendPages.value = JSON.parse(recommendPagesInLocalStorage)._value;
        }

        const pageItemInLocalStorage = localStorage.getItem("pageItem");
        if (pageItemInLocalStorage) {
            pageItem.value = JSON.parse(pageItemInLocalStorage)._value;
        }
        const topPagesInLocalStorage = localStorage.getItem("topPages");
        if (topPagesInLocalStorage) {
            topPages.value = JSON.parse(topPagesInLocalStorage);
        }

        const pagesInLocalStorage = localStorage.getItem("pages");
        if (pagesInLocalStorage) {
            pages.value = JSON.parse(pagesInLocalStorage)._value;
        }
    }

    const setPageItem = async (url:String, param:String) => {
        loader.value = true;
        // @ts-ignore
        langStore.locale =param
        // @ts-ignore
        await  axios.get(appConfig['publicUrl']+ '/api/journal-item/' + url,{
            method: 'GET',
            // @ts-ignore
            json: true,
            headers: {'X-X-Locale': langStore.locale}
        })
            .then(response => {

                pageItem.value = response.data.data
                if(response.data.data.id!==null) {
                    // @ts-ignore
                    axios.get(appConfig.publicUrl + '/api/recommend-pages/1')
                        .then(res => {
                            // console.log(response.data.data)
                            recommendPages.value = res.data.data
                            loader.value = false;
                        })
                }

            })


    }

    const loadTopPages = async (param:String) => {
        loader.value = true;
        // @ts-ignore
        langStore.locale =param
        // @ts-ignore
        await  axios.get(appConfig['publicUrl'] + '/api/journal/top-pages',{
            method: 'GET',
            // @ts-ignore
            json: true,
            headers: {'X-X-Locale': langStore.locale}
        })
            .then(response => {
                topPages.value = response.data.data
                loader.value = false;
            })
    }

    const loadPages = async (param:String, category:String, page:Number=1) => {
        loader.value = true;
        // @ts-ignore
        langStore.locale =param
        // @ts-ignore
        await  axios.get(appConfig['publicUrl'] + '/api/journal/'+ category+'/'+page,{
            method: 'GET',
            // @ts-ignore
            json: true,
            headers: {'X-X-Locale': langStore.locale}
        })
            .then(response => {
                // console.log(response.data)
                pages.value = response.data.data
                pagination.value = response.data.meta
                console.log(pages.value)
                loader.value = false;
            })
    }
    // const loadRecommendPages = async (category:Number) => {
    //     loader.value = true;
    //     await  axios.get(appConfig.publicUrl + '/api/journal/recommend-pages/'+ category)
    //         .then(response => {
    //             console.log(response.data.data)
    //             recommendPages.value = response.data.data
    //             loader.value = false;
    //         })
    // }


    watch(
        () =>pagination,
        (state) => {
            // console.log(state.value)
            localStorage.setItem("paginationJournal", JSON.stringify(state.value));
        },
        { deep: true }
    );

    watch(
        () =>recommendPages,
        (state) => {
            // console.log(state.value)
            localStorage.setItem("recommendPages", JSON.stringify(state.value));
        },
        { deep: true }
    );

    watch(
        () =>pageItem,
        (state) => {
            localStorage.setItem("pageItem", JSON.stringify(state.value));
        },
        { deep: true }
    );

    watch(
        () =>topPages,
        (state) => {
            if(state.value.length >  0) {
                localStorage.setItem("topPages", JSON.stringify(state.value));
            }
        },
        { deep: true }
    );

    watch(
        () =>pages,
        (state) => {
            // console.log(state)
            localStorage.setItem("pages", JSON.stringify(state.value));
        },
        { deep: true }
    );

    return {
        topPages,
        pages,
        loader,
        pageItem,
        pagination,
        recommendPages,
        loadTopPages,
        loadPages,
        setPageItem
    };
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useJournalStore, import.meta.hot));
}
