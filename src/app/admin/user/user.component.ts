import { Component, OnInit } from '@angular/core';
import { UserService } from './../../service/user.service';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import {Title} from '@angular/platform-browser';
import { trigger, state, style, animate, transition } from '@angular/animations';


@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css'],
  animations: [
       trigger("openClose", [
              state('open', style({
                   transform: 'translateX(0)',
              })),
              state('close', style({
                   transform: 'translateX(100%)',
              })),
              transition("open <=> close", animate("300ms linear"))
       ]),
       trigger("showHide", [
            state('show', style({
                  transform: 'translateY(0)',
            })),
            state('hide', style({
                  transform: 'translateY(-230%)',
            })),
            transition("show <=> hide", animate("400ms linear"))
      ])
]
})
export class UserComponent implements OnInit {

  constructor(
       private user: UserService,
     private loader: LoadingBarService,
     private toast: ToastService,
     private router: Router,
     private title: Title
 ) { }
      subscriptions!: Subscription
      navigation: boolean =  false
      searchParameter: string = ''
      users: Array<any> = []
      classes = {show: '', hide: '', form: false}
      navButtons = {prev: null, next: null}
      RoleToAdd: string  = ''
      viewUser: any = null

       ngOnInit(): void
       {
            this.getAllUsers()
       }

       trackByFn(index: number, topic: any)
       {
            return topic ? topic.id : undefined;
       }

       getAllUsers()
       {
            this.loader.start()
            this.subscriptions = this.user.getAllUsers().subscribe(
                 (response) => {
                      this.users = response.data.data
                      this.navButtons.prev = response.data.prev_page_url
                      this.navButtons.next = response.data.next_page_url
                      this.loader.complete()
                 },
                 (error) => {
                     this.loader.complete()
                     this.toast.error("Unable to load your topics")
                     if(error.status == 401 )
                     {
                          this.router.navigate(["/admin"])
                     }
                 }
            )
       }

       paginateUsers(url: string)
       {
            this.loader.start()
            this.subscriptions = this.user.paginateUsers(url).subscribe(
                 (response) => {
                      this.users = response.data.data
                      this.navButtons.prev = response.data.prev_page_url
                      this.navButtons.next = response.data.next_page_url
                      this.loader.complete()
                 },
                 (error) => {
                    this.loader.complete()
                    this.toast.error("Unable to load your topics")
                 }
            )
       }

       ChooseRole($event: any, user_id: number)
       {
            if (confirm("Make "+this.viewUser.name + " an " + $event.target.value)) {
                 this.loader.start()
                 this.subscriptions = this.user.AddRoleToUser({role: $event.target.value, user_id: user_id}).subscribe(
                      (response: any) => {
                           this.viewUser = response.data
                           this.toast.success("User role has been updated")
                           this.loader.complete()
                      },
                      (error) => {
                          this.loader.complete()
                          this.toast.error("Unable to Add role to user")
                          // if(error.status == 401 )
                          // {
                          //      this.router.navigate(["/admin"])
                          // }
                      }
                 )
            }
       }

       removeRole(role: string, user_id:number)
       {
            if (confirm("Remove "+this.viewUser.name + " " + role + "'s' priviledges")) {
                 this.loader.start()
                 this.subscriptions = this.user.removeRoleFromUser({role: role, user_id: user_id}).subscribe(
                      (response: any) => {
                           this.viewUser = response.data
                           this.toast.success("User role has been updated")
                           this.loader.complete()
                      },
                      (error) => {
                          this.loader.complete()
                          this.toast.error("Unable to Add role to user")
                          // if(error.status == 401 )
                          // {
                          //      this.router.navigate(["/admin"])
                          // }
                      }
                 )
            }
       }

       searchUsers()
       {
            // searchParameter
            this.loader.start()
            this.subscriptions = this.user.searchForUser(this.searchParameter).subscribe(
                 (response: any) => {
                     this.users = response.data.data
                     this.navButtons.prev = response.data.prev_page_url
                     this.navButtons.next = response.data.next_page_url
                     this.loader.complete()
                 },
                 (error) => {
                     this.loader.complete()
                     this.toast.error("Cannot find a user with the search term")
                     if(error.status == 401 )
                     {
                          this.router.navigate(["/admin"])
                     }
                 }
          )
       }

       showSideNavigation(user: any): void
      {
          this.navigation = !this.navigation
          this.viewUser = user
      }
}
