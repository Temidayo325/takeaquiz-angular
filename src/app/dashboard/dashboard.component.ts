import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import {StoreService } from '../Services/store.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  constructor(
       private router: Router,
       private toast: ToastService,
       private store: StoreService
 ) {

}

     public user: any = this.store.getUser();
  ngOnInit(): void {
       // console.log(this.user)
       if (this.store.token == null || this.store.token == '') {
            this.router.navigate(['/login'])
       }
  }
  logout()
  {

  }
}
