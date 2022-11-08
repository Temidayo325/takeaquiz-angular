import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { StoreService } from './../../service/store.service';
import { UserService } from './../../service/user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-dashboard',
  templateUrl: './user-dashboard.component.html',
  styleUrls: ['./user-dashboard.component.css']
})
export class UserDashboardComponent implements OnInit {

  constructor(
      private storeService: StoreService,
      private loader: LoadingBarService,
      private toast: ToastService,
      private router: Router,
      private userService: UserService
 ) { }
  public result: Array<[]> = JSON.parse(sessionStorage.getItem('results')!)
  public countedResult: number = this.result === null ? 0 : this.result.length
  ngOnInit(): void
  {
  }

  logout()
  {
       if (confirm("Do you want to log out of your account?")) {
            this.loader.start()
            let user = JSON.parse(sessionStorage.getItem('user')!)
            this.userService.logout(user.id).subscribe(
                 (response: any) => {
                      this.loader.complete()
                      if (response.status) {
                           sessionStorage.clear()
                           localStorage.clear()
                           this.router.navigate(['/login'])
                      }
                 },
                 (error) => {
                      this.loader.complete()
                      this.toast.error(error.message)
                 }
            )
       }
  }
}
