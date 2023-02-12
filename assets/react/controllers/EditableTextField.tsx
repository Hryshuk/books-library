import { ChangeEvent, Dispatch, FC, SetStateAction, useState, SyntheticEvent } from 'react';
import { IBook, IEditable } from './Books';

interface IEditableFieldProps {
    editable: any;
    setEditable: Dispatch<SetStateAction<IEditable>>;
    setData: Dispatch<SetStateAction<IBook[]>>;
    name: string;
    id: number;
    value: string;
}

const EditableTextField: FC<IEditableFieldProps> = ({
    editable,
    setEditable,
    setData,
    id,
    name,
    value: initialValue,
}) => {
    const [value, setValue] = useState<string>(initialValue);
    const [error, setError] = useState<string>('');

    const handlerChange = (e: ChangeEvent<HTMLInputElement>) => {
        setValue(e.target.value);
    };

    const handlerBlur = async (e: SyntheticEvent) => {
        e.stopPropagation();

        if (initialValue === value) {
            setEditable({
                name: null,
                id: null,
                isActive: false,
            });
            setError(null);
            return;
        }

        try {
            const requestOptions = {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ [name]: value }),
            };
            const response = await fetch(`/api/books/${id}`, requestOptions);
            const data = await response.json();

            if (response.status === 200) {
                setData((old) => old.map((row) => (row.id === id ? data?.data : row)));
                setEditable({
                    name: null,
                    id: null,
                    isActive: false,
                });
                setError(null);
            } else if (response.status === 422) {
                setError(data?.errors[name].join('. '));
            }
        } catch (e) {
            setError(e);
        }
    };

    const handlerSubmit = (e: SyntheticEvent) => {
        e.preventDefault();
        handlerBlur(e);
    };

    const handlerClick = () => {
        setEditable({
            name: name,
            id: id,
            isActive: true,
        });
        setValue(initialValue);
        setError(null);
    };

    const Form = () => {
        return (
            <form onSubmit={handlerSubmit}>
                <input
                    required
                    value={value}
                    onChange={handlerChange}
                    onBlur={handlerBlur}
                    autoFocus
                    className={`form-control form-control-sm ${error && 'is-invalid'}`}
                    style={{ maxWidth: '100px' }}
                />
                {error && (
                    <span className="invalid-feedback d-block">
                        <span className="form-error-message">{error}</span>
                    </span>
                )}
            </form>
        );
    };

    return (
        <div onClick={handlerClick} style={{ minHeight: '24px', cursor: 'pointer' }}>
            {editable.isActive && editable.id === id && editable.name === name ? <Form /> : <span>{initialValue}</span>}
        </div>
    );
};

export default EditableTextField;
