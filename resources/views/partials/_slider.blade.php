<!-- slider -->
<section id="slider" class="no-padding content-top-margin">
    <div id="owl-demo" class="owl-carousel owl-theme owl-half-slider dark-pagination">
        @foreach($sliders as $slider)
        <div class="item owl-bg-img" style="background-image:url('images/slider/{{ $slider->image }}');">
            <div class="container position-relative">
                <div class="slider-typography text-left">
                    <div class="slider-text-middle-main">
                        <div class="slider-text-middle padding-left-right-px animated fadeInUp">
                            @if($slider->title != '')
                                <span class="owl-title white-text" style="background: rgba(0,0,0,0.5); padding: 10px;">
                                    {{ $slider->title }}<br/>
                                    @if($slider->button != '')
                                        <a href="{{ $slider->url }}" class="highlight-button-white-border btn btn-medium" target="_blank">{{ $slider->button }}</a>
                                    @endif
                                </span>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- end slider -->