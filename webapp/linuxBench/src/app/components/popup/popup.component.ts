import { Component } from '@angular/core';
import { Clipboard } from '@angular/cdk/clipboard';
import {BenchNameService} from '../../services/bench-name.service';

@Component({
  selector: 'app-popup',
  imports: [],
  templateUrl: './popup.component.html',
  styleUrl: './popup.component.css'
})
export class PopupComponent {
  name:string = "";
  c1:string = "";
  c2:string = "";
  c3:string = "";
  constructor (private clipboard:Clipboard, private bench:BenchNameService){
    this.name = this.bench.benchName;
    this.c1 = "wget https://raw.githubusercontent.com/KostasEreksonas/benchmarking-linux/refs/heads/main/benchmarks/benchmark-" + this.name;
    this.c2 = "chmod +x benchmark-" + this.name;
    this.c3 = "./benchmark-" + this.name;
  }

  copyToClipboard(x:string){
    this.clipboard.copy(x);
  }
}
