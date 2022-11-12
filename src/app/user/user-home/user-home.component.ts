import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { StoreService } from './../../service/store.service';
import { UserService } from './../../service/user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-home',
  templateUrl: './user-home.component.html',
  styleUrls: ['./user-home.component.css']
})
export class UserHomeComponent implements OnInit {

  constructor(
       private storeService: StoreService,
      private loader: LoadingBarService,
      private toast: ToastService,
      private router: Router,
      private userService: UserService
 ) { }

  public result: Array<[]> = JSON.parse(sessionStorage.getItem('results')!)
  public countedResult: number = this.result === null ? 0 : this.result.length
  public topics: Array<any> = JSON.parse(sessionStorage.getItem('topics')!)
  public results: Array<any> = JSON.parse(sessionStorage.getItem('results')!)
  
  ngOnInit(): void
  {

  }
  trackByFn(index: number, result: any)
  {
        return result ? result.id : undefined;
  }
}
