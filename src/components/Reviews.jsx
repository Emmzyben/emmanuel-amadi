import React, { useState, useEffect } from 'react';
import { ref, get } from 'firebase/database';
import { db } from '../config/firebase';
import Slider from 'react-slick';

const Reviews = () => {
    const [reviews, setReviews] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchReviews = async () => {
            try {
                const snapshot = await get(ref(db, 'reviews'));
                if (snapshot.exists()) {
                    const data = snapshot.val();
                    const revs = Object.keys(data).map(key => ({ id: key, ...data[key] }));
                    revs.sort((a, b) => new Date(b.created_at || Date.now()) - new Date(a.created_at || Date.now()));
                    setReviews(revs);
                }
            } catch (error) {
                console.error("Error fetching reviews", error);
            } finally {
                setLoading(false);
            }
        };

        fetchReviews();
    }, []);

    const settings = {
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
    };

    return (
        <div className="review" id="review">
            <div className="content-inner">
                <div className="content-header">
                    <h2>Reviews</h2>
                </div>
                <div className="row align-items-center review-slider">
                    {loading ? (
                        <div className="col-12 text-center py-5">
                            <p className="text-white">Loading reviews...</p>
                        </div>
                    ) : reviews.length === 0 ? (
                        <div className="col-12 text-center py-5">
                            <p className="text-white">No reviews yet</p>
                        </div>
                    ) : (
                        <div className="col-md-12">
                            <Slider {...settings}>
                                {reviews.map(rev => (
                                    <div key={rev.id} className="review-slider-item">
                                        <div className="review-text">
                                            <p>{rev.review_text}</p>
                                        </div>
                                        <div className="review-img">
                                            <div className="review-name">
                                                <h3>{rev.reviewer_name}</h3>
                                                <p>{rev.location}</p>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </Slider>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

export default Reviews;
