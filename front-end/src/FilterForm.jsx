import React, { useState } from 'react';
import axios from 'axios';

function FilterForm() {
    const [formData, setFormData] = useState({
        password: '',
        fullName: '',
        phoneNumber: '',
        filterType: '',
    });
    const [errors, setErrors] = useState({});

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleReset = () => {
        setFormData({
            password: formData.password,
            fullName: '',
            phoneNumber: '',
            filterType: '',
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({}); // reset previous errors

        try {
            const response = await axios.post('http://filter-reminder.localhost/api/create', 
                formData, 
            {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            
            if (response.data.isSaved) {
                alert('Entry submitted successfully!');
                handleReset();
            } else {
                setErrors(response.data.errors)
            }
        } catch (error) {
            console.error('Submission error:', error);
            alert('There was a problem submitting the form.');
        }
    };

    return (
        <div className="container vh-100">
            <div className="row align-items-center h-100">
                <div className="col-12">
                    <h2 className="mb-4">Water Filter Cartridge Replacement Reminder</h2>
                    <p>This is just a demo software, to see the source code <a href="https://github.com">click here</a></p>
                    <p>⚠️ Access to the live demo is protected by a temporary secret token to prevent abuse. If you'd like to test the working Twilio integration, contact me at <a href="mailto:wellingtonarcangel@gmail.com">wellingtonarcangel@gmail.com</a> and I’ll send you an access token that lasts 1 hour after first use. You're only allowed 5 uses per token</p>
                    <form onSubmit={handleSubmit} className="card p-4 shadow-sm">
                        <div className="mb-3">
                            <label htmlFor="password" className="form-label">Secret Token</label>
                            <input
                                type="text"
                                className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                                id="password"
                                name="password"
                                value={formData.password}
                                onChange={handleChange}
                                required
                            />
                            {errors.password && <div className="invalid-feedback">{errors.password}</div>}
                        </div>
                        <div className="mb-3">
                            <label htmlFor="fullName" className="form-label">Name</label>
                            <input
                                type="text"
                                className={`form-control ${errors.fullName ? 'is-invalid' : ''}`}
                                id="fullName"
                                name="fullName"
                                value={formData.fullName}
                                onChange={handleChange}
                                required
                            />
                            {errors.fullName && <div className="invalid-feedback">{errors.fullName}</div>}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="phoneNumber" className="form-label">Phone Number</label>
                            <input
                                type="tel"
                                className={`form-control ${errors.phoneNumber ? 'is-invalid' : ''}`}
                                id="phoneNumber"
                                name="phoneNumber"
                                value={formData.phoneNumber}
                                onChange={handleChange}
                                required
                                maxLength={10}
                                placeholder='8005551234'
                            />
                            {errors.phoneNumber && <div className="invalid-feedback">{errors.phoneNumber}</div>}
                        </div>

                        <div className="mb-4">
                            <label htmlFor="filterType" className="form-label">Select Water Filter Type</label>
                            <select
                                className={`form-control ${errors.filterType ? 'is-invalid' : ''}`}
                                id="filterType"
                                name="filterType"
                                value={formData.filterType}
                                onChange={handleChange}
                                required
                            >
                                <option value="">Choose...</option>
                                <option value="FrescaPure 3500">FrescaPure 3500</option>
                                <option value="FrescaPure 5500">FrescaPure 5500</option>
                                <option value="Ultra">Ultra</option>
                            </select>
                            {errors.filterType && <div className="invalid-feedback">{errors.filterType}</div>}
                        </div>

                        <button type="submit" className="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    );
}

export default FilterForm;