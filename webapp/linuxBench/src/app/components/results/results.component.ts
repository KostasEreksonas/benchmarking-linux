import { Component } from '@angular/core';
import {CommonModule} from '@angular/common';
import {ActivatedRoute, RouterLink} from '@angular/router';
import {LoadingComponent} from '../loading/loading.component';
import {FooterComponent} from '../footer/footer.component';
import {Bench} from '../../models/bench';
import {BenchResultsService} from '../../services/bench-results.service';

@Component({
  selector: 'app-results',
  imports: [
    CommonModule,
    RouterLink,
    LoadingComponent,
    FooterComponent
  ],
  templateUrl: './results.component.html',
  styleUrl: './results.component.css'
})
export class ResultsComponent {
  public title:string = "";

  public benches:Bench[] = [];
  public isLoading:boolean = false;
  public isError:boolean = false;
  public status:string = '';
  public message:string = '';
  public benchmark:string = '';

  private loadData(){
    this.isLoading = true;
    this.benchService.benchResults(this.benchmark).subscribe({
      next:(data)=>{
        this.benches = data.sort((a, b) => a.fastest - b.fastest);
        this.benchService.onResultCountChange.emit();
        this.isLoading = false;
        this.isError = false;
      },
      error:(error)=>{
        this.isError = true;
        this.isLoading = false;
        this.status = error.status;
        if (error.error === null) {
          this.message = error.message;
        } else {
          this.message = error.error.message;
        }
      }
    })
  }

  public constructor(private route:ActivatedRoute, private benchService:BenchResultsService) {
    this.benchmark = this.route.snapshot.params["benchmark"];
    this.title = this.benchmark;
    this.loadData();
  }

  public deleteResult(id:string|null){
    if (id != null) {
      this.benchService.deleteResult(this.benchmark, id).subscribe(()=>{
        this.loadData();
      });
    }
  }
}
