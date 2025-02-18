import { Component } from '@angular/core';
import {RouterLink, RouterOutlet} from "@angular/router";
import {MatDialog} from '@angular/material/dialog';
import {PopupComponent} from '../popup/popup.component';
import {BenchNameService} from '../../services/bench-name.service';

@Component({
  selector: 'app-bench-info',
    imports: [
        RouterLink,
        RouterOutlet
    ],
  templateUrl: './bench-info.component.html',
  styleUrl: './bench-info.component.css'
})
export class BenchInfoComponent {
  public b1 = "ffmpeg";
  public b2 = "fibonacci";
  public b3 = "pi";
  public b4 = "openssl";
  public b5 = "power";
  public b6 = "povray";

  constructor(private dialog:MatDialog, private benchName:BenchNameService){}

  openDialog(x:string){
    this.benchName.benchName = x;
    this.dialog.open(PopupComponent);
  }
}
