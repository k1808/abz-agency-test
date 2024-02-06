import {acceptHMRUpdate, defineStore} from 'pinia'
// @ts-ignore
import axios, {AxiosError, AxiosResponse} from "axios";

// @ts-ignore
import {ref} from 'vue'
import type {UsersInterface} from "~/types/interfaces";

export const useUsersStore = defineStore('UsersStore', () => {

    const next_link = ref(null);
    const prev_link = ref(null);
    const current_page = ref(null);
    const errMsg = ref(null);
    const loader = ref(false)
    const total_pages = ref(1)
    const users = ref([])
    const user = ref({})
    const usersShowMore = ref([])

    const appConfig = useAppConfig()

    if (typeof window !== 'undefined') {
        const usersInLocalStorage = localStorage.getItem("users");
        if (usersInLocalStorage) {
            users.value = JSON.parse(users);
        }
    }

    const clearShowMore = () => usersShowMore.value =[]

    const getUsers = async ({
        count = 5,
          offset = null,
          page = current_page.value,
    }: { count?: number; offset?: number|null; page?: number } = {}) => {
        loader.value = true;
        await axios.get(`${appConfig["publicUrl"]}/api/users`, {
            params: { count, offset, page }
        })
          .then((response: AxiosResponse<UsersInterface>) => {
            total_pages.value=1;
            users.value = response.data.users;
            usersShowMore.value = [...usersShowMore.value, ...response.data.users];
            next_link.value= response.data.links.next_link;
            prev_link.value = response.data.links. prev_link;
            current_page.value = response.data.page;
            console.log(response.data);
            loader.value = false;
          })
          .catch((err: AxiosError) => {
              errMsg.value = err.response.data.message;
              loader.value = false;
          });

    }

    const getUserOne = async (id:number) => {
        loader.value = true;
        await axios.get(`${appConfig["publicUrl"]}/api/users/`+id)
          .then((response: AxiosResponse<UsersInterface>) => {
            console.log(response.data.user)
              user.value = response.data.user;
              loader.value = false;
          })
          .catch((err: AxiosError) => {
            errMsg.value = err.response.data.message;
              loader.value = false;
          });

    }
    watch(
      () => errMsg,
      (state: string|null) => {
        setTimeout(()=> errMsg.value = null, 5000);

      },
      {deep: true}
    );

    return {
        loader,
        current_page,
        errMsg,
        user,
        users,
        usersShowMore,
        total_pages,
        next_link,
        prev_link,
        getUsers,
        clearShowMore,
      getUserOne

    };
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUsersStore, import.meta.hot));
}
