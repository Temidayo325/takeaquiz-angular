import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { StoreService } from './../../service/store.service';
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
 ) { }
  public result: Array<[]> = JSON.parse(sessionStorage.getItem('results')!)
  public countedResult: number = this.result.length
  ngOnInit(): void {
  }

}
