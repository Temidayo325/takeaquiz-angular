import { Component, OnInit } from '@angular/core';
import { StoreService } from '../Services/store.service';

@Component({
  selector: 'app-dashboard-header',
  templateUrl: './dashboard-header.component.html',
  styleUrls: ['./dashboard-header.component.scss']
})
export class DashboardHeaderComponent implements OnInit {

  constructor(
       private store: StoreService
 ) { }

  public user: any = this.store.getUser();

  ngOnInit(): void {
  }

}
