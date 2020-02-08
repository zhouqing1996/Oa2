import Home from '../pages/home/Index.vue'
import Content from '../pages/home/Content.vue'
import Login from '../pages/home/Login.vue'

import Doc from '../pages/document/Index'
import Mycontact from '../pages/document/Mycontact'
import Myfile from '../pages/document/Myfile'
import Flownew from '../pages/document/Flownew'//新建流程
import Flowschedule from '../pages/document/Flowschedule'//待办流程
import Flowmy from '../pages/document/Flowmy'//我的流程
import Flowok from "../pages/document/Flowok";//成功审批流程
import Flowsp from "../pages/document/Flowsp";//审批流程 参与者审批人


import List1 from "../pages/document/List/List1";
import List2 from "../pages/document/List/List2";
import List3 from "../pages/document/List/List3";
import Listnew from "../pages/document/List/Listnew";
import Application from "../pages/document/List/Application";

import Looklist3 from "../pages/document/LookList/Looklist3";
import Looklist2 from "../pages/document/LookList/Looklist2";
import Looklist1 from "../pages/document/LookList/Looklist1";

import Testindex from "../pages/test/Index";
import Test from "../pages/test/Test";


export default [
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/document/index',
    name:'docu',
    component:Doc
  },
  {
    path:'/document/list/list1',
    name:'list1',
    component:List1
  },
  {
    path:'/document/list/list2',
    name:'list2',
    component:List2
  },
  {
    path:'/document/list/list3',
    name:'list3',
    component:List3
  },
  {
    path:'/document/list/listnew',
    name:'listnew',
    component:Listnew
  },
  {
    path:'/document/list/application',
    name:'application',
    component:Application
  },
  {
    path:'/document/LookList/Looklist1',
    name:'looklist1',
    component:Looklist1
  },
  {
    path:'/document/LookList/Looklist2',
    name:'looklist2',
    component:Looklist2
  },
  {
    path:'/document/LookList/Looklist3',
    name:'looklist3',
    component:Looklist3
  },
  {
    path:'/test/Index',
    name:'testindex',
    component:Testindex
  },
  {
    path:'/test/Test',
    name:'test',
    component:Test
  },
  {
    path: '/home',
    redirect: '/home/login',
    component: Home,
    children: [
      {
        path: 'index',
        component: Content
      },
      {
        path:'content',
        component:Content
      },
      {
        path: 'login',
        component: Login
      }
    ]
  },
  {
    path: '/document/index',
    name: 'Doc',
    component: Doc,
    children: [
      {
        // 通讯录
        path: '/document/mycontact',
        name: 'mycontact',
        component: Mycontact
      },
      {
        // 个人文件柜
        path: '/document/myfile',
        name:'myfile',
        component:Myfile
      },
      {
        // 新建流程
        path: '/document/flownew',
        name:'flownew',
        component:Flownew
      },
      {
        // 待办流程
        path: '/document/flowschedule',
        name:'flowschedule',
        component:Flowschedule
      },
      {
        // 我的流程
        path:'/document/flowmy',
        name:'flowmy',
        component:Flowmy
      },
      {
        // 已审流程
        path:'/document/flowok',
        name:'flowok',
        component:Flowok
      },
      {
        // 审批流程
        path:'/document/flowsp',
        name:'flowsp',
        component:Flowsp
      },

    ]
  }
]
