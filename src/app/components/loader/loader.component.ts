import { Component, OnInit, Input } from '@angular/core';
import { trigger, state, style, animate, transition, } from '@angular/animations';

@Component({
  selector: 'app-loader',
  templateUrl: './loader.component.html',
  styleUrls: ['./loader.component.css'],
  animations: [
    trigger("openClose", [
          state('open', style({
               transform: 'translateY(0)',
          })),
          state('close', style({
               transform: 'translateY(-100%)',
          })),
          transition("open <=> close", animate("300ms linear"))
    ])
     ]
})
export class LoaderComponent implements OnInit {

  constructor() { }
  @Input() display: boolean = true

  ngOnInit(): void
  {
  }

}
