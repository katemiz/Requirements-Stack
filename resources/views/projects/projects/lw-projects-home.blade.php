<script type="application/javascript">
  function draw() {

    let d = document.getElementById('div_canvas');

    let bounding_box = d.getBoundingClientRect()

    let parent_w = bounding_box.width
    let parent_h = 0.5*parent_w

    let scale = parent_w/100


    let canvas = document.createElement('canvas')
    canvas.id = 'canvas'
    canvas.width = parent_w
    canvas.height = parent_h
    canvas.classList.add('has-background-warning')

    d.append(canvas)








    if (canvas.getContext) {
      const ctx = canvas.getContext("2d");

      ctx.fillStyle = "rgb(200, 0, 0)";
      ctx.fillRect(3*scale, 3*scale, 47*scale, 4*scale);

      ctx.fillStyle = "rgba(0, 0, 200, 0.5)";
      ctx.fillRect(50*scale, 3*scale, 47*scale, 4*scale);


      ctx.fillStyle = "rgba(255, 255, 255, 1)";
      ctx.font = "16px sans-serif";
      ctx.textAlign = "center";
      ctx.textBaseline = "middle";



      ctx.fillText("Formulation Phase", 25.5*scale, 5*scale);
      ctx.fillText("Implementation Phase", 75.5*scale, 5*scale);


    }
  }



  
</script>

<section class="section container">

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Project Timeline</h1>
        <h2 class="subtitle has-text-weight-light">Project Phases, Project Decision Gates/Review Gates Relationships</h2>
    </header>
    

    <div id="div_canvas" class="has-background-grey">


    </div>





</section>

<script>
    draw();
</script>

    